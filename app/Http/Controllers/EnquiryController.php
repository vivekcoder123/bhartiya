<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Service;
use App\Models\Location;
use App\Models\Bank;
use App\Models\User;
use App\Models\Designation;
use App\Models\Enquiry;
use App\Models\EnquiryActivityTracking;
use App\Models\EnquiryStatusTracking;
use App\Models\ExistingLoanDetail;
use App\Models\StaffService;
use App\Models\ServiceFormAttribute;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $services = Service::where('status','1')->get();
            $staffs = Staff::get();
            $users = User::where('status','1')->get();
            $locations = Location::where('status','1')->get();
            $status_name_query = Enquiry::STATUS_NAME_QUERY;
            $enquiries = Enquiry::with(['location:id,name','user','bank:id,name','propose_bank:id,name','service:id,service_type','relationship_manager:id,name','enquiry_status'=>function($query) use($status_name_query){
                $query->selectRaw("id,enquiry_id,created_at,$status_name_query");
            },'enquiry_activiy','existing_loan'])->selectRaw("*,$status_name_query")->get();
            $statuses = Enquiry::STATUSES_ARRAY;
            return view('admin.enquiries.index',compact('staffs','locations','services','users','enquiries','statuses'));
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage().",line:".$e->getLine());
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $request->validate([
            'user_id' => 'required',
            'service_id' => 'required',
            'location_id' => 'required',
            'relationship_manager_id' => 'required'
        ]);
        DB::beginTransaction();
        try{
            $input = [];
            $input = $request->all();

            $fields = ['aadhar','pan','address_proof','payslip','return_statement','bank_statement','others'];

            foreach ($fields as $f) {
                $data = [];
                if($files=$request->file($f)){
                    foreach($files as $file){
                        $file_name=time().$file->getClientOriginalName();
                        $file->move('uploads',$file_name);
                        array_push($data,$file_name);
                    }
                }
                $input[$f] =implode(',',$data);
            }

            $current_time = date("Y-m-d H:i:s");
            unset($input['_token']);
            $input['created_at'] = $current_time;
            $input['updated_at'] = $current_time;
            $enquiry_id=Enquiry::insertGetId($input);

                $enquiry_tracking_data[] = [
                    'enquiry_id'=>$enquiry_id,
                    'status'=>0,
                    'created_at'=>$current_time,
                    'updated_at'=>$current_time
                ];

            EnquiryStatusTracking::insert($enquiry_tracking_data);

            DB::commit();
            return redirect()->back()
                ->with('success', 'Enquiry created successfully.');

        }catch(\Exception $e){
            DB::rollback();
            return Redirect::back()->with('error',$e->getMessage().",line:".$e->getLine());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function updateEnquiry(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required',
            'service_id' => 'required',
            'location_id' => 'required',
            'relationship_manager_id' => 'required'
        ]);
        DB::beginTransaction();
        try{
            $input = [];
            $input = $request->all();
            unset($input['_method']);
            unset($input['_token']);

            $fields = ['aadhar','pan','address_proof','payslip','return_statement','bank_statement','others'];


            $pre_enquiry = Enquiry::where('id',$id)->first();

            foreach ($fields as $f) {
                $doc_name = [];
                $new_doc = '';
                if($files=$request->file($f)){
                    foreach($files as $file){
                        $file_name=time().$file->getClientOriginalName();
                        $file->move('uploads/',$file_name);
                        array_push($doc_name,$file_name);
                    }
                    $new_doc =implode(',',$doc_name);
                    $input[$f] = $new_doc.','.$pre_enquiry->{$f};

                }else{
                    $input[$f] = $pre_enquiry->{$f};
                }
            }


            $updated_enquiry=Enquiry::where('id',$id)->update($input);


            DB::commit();
            return redirect()->back()
                ->with('success', 'Enquiry updated successfully.');

        }catch(\Exception $e){
            DB::rollback();
            return Redirect::back()->with('error',$e->getMessage());
        }
    }

    public function get_dynamic_data(Request $request){
        $service = Service::with('banks:id,name','fields.attribute_type')->find($request->service_id);
        if($service){
            $view = view('admin.services.dynamic_data',compact('service'));
            return $view->render();
        }else{
            return '';
        }
    }

    public function get_service_tenure_data(Request $request){

        $service = Service::where('service_type',$request->service_id)->first();
        if($service){
            return $service;
        }else{
            return '';
        }
    }


    public function get_edit_dynamic_data(Request $request){
        $service = Service::with('banks:id,name','fields.attribute_type')->find($request->service_id);
        $enquiry = Enquiry::find($request->enquiry_id);
        if($service && $enquiry){
            $view = view('admin.services.edit_dynamic_data',compact('service','enquiry'));
            return $view->render();
        }else{
            return '';
        }
    }

    public function get_loan_bank_data(Request $request){
        $service = Service::with('banks:id,name')->find($request->service_id);
        if($service){
            $view = view('admin.services.dynamic_data_bank',compact('service'));
            return $view->render();
        }else{
            return '';
        }
    }

    public function save_enquiry_activity(Request $request){
        try{
            DB::beginTransaction();
            $current_time = date("Y-m-d H:i:s");
                $data_to_insert[] = [
                    'enquiry_id'=>$request->enquiry_id,
                    'note'=>$request->note,
                    'created_at'=>$current_time,
                    'updated_at'=>$current_time
                ];

            EnquiryActivityTracking::insert($data_to_insert);
            DB::commit();
            return redirect()->back()->with('success',"Enquiry Activity data saved successfully!");
        }catch(Exception $e){
            DB::rollback();
            return redirect()->back()->with('error',$e->getMessage().",line:".$e->getLine());
        }
    }

     public function save_existing_loan(Request $request){
        try{
            DB::beginTransaction();

            $current_time = date("Y-m-d H:i:s");
                $data_to_insert[] = [
                    'enquiry_id'=>$request->enquiry_id,
                    'bank'=>$request->bank,
                    'product'=>$request->product,
                    'loan_amount'=>$request->loan_amount,
                    'tenure'=>$request->tenure,
                    'emi'=>$request->emi,
                    'created_at'=>$current_time,
                    'updated_at'=>$current_time
                ];

            ExistingLoanDetail::insert($data_to_insert);
            DB::commit();
            return redirect()->back()->with('success',"Existing Loan data saved successfully!");
        }catch(Exception $e){
            DB::rollback();
            return redirect()->back()->with('error',$e->getMessage().",line:".$e->getLine());
        }
    }


    public function save_eligible_loan_amount(Request $request){
        try{

            $enquiry = Enquiry::find($request->enquiry_id);
            $enquiry->eligible_loan_amount = $request->eligible_loan_amount;
            $enquiry->save();

            return redirect()->back()->with('success',"Eligible Loan Amount data saved successfully!");
        }catch(Exception $e){

            return redirect()->back()->with('error',$e->getMessage().",line:".$e->getLine());
        }
    }


    public function change_enquiry_status(Request $request){
        try{

            DB::beginTransaction();
            $enquiry = Enquiry::find($request->enquiry_id);
            $enquiry->status = $request->status;
            $enquiry->save();

            $current_time = date("Y-m-d H:i:s");

            $enquiry_tracking_data = [
                'enquiry_id'=>$enquiry->id,
                'status'=>$request->status,
                'created_at'=>$current_time,
                'updated_at'=>$current_time
            ];

            EnquiryStatusTracking::create($enquiry_tracking_data);
            DB::commit();

            return redirect()->back()->with('success',"Enquiry Status Updated successfully!");
        }catch(Exception $e){
            DB::rollback();
            return redirect()->back()->with('error',$e->getMessage().",line:".$e->getLine());
        }
    }


    public function asign_propose_bank(Request $request){
        try{

            $enquiry = Enquiry::find($request->enquiry_id);
            $enquiry->propose_bank_id = $request->propose_bank_id;
            $enquiry->save();

            return redirect()->back()->with('success',"Propose Bank added successfully!");
        }catch(Exception $e){

            return redirect()->back()->with('error',$e->getMessage().",line:".$e->getLine());
        }
    }

    public function getDeleteSelectedImages(Request $request){

        try{
            $image_name = $request->image_name;
            $enquiry_id = $request->enquiry_id;
            $doc = $request->doc_type;
            $enquiry = Enquiry::where('id',$enquiry_id)->first();

            $images_array = explode(',',$enquiry->{$doc});

            $pos = array_search($image_name, $images_array);

            unset($images_array[$pos]);

            $new_images =implode(',',$images_array);

            Enquiry::where('id', $enquiry_id)->update(array($doc => $new_images));
            unlink(public_path().'/uploads/'.$image_name);

            return 'success';

        }catch(Exception $e){
            return $e->getMessage();
        }

    }
}
