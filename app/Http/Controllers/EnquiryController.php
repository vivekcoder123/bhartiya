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
use App\Models\EnquiryActivityTracker;
use App\Models\EnquiryStatusTracking;
use App\Models\ExistingLoanDetail;
use App\Models\StaffService;
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
            $banks = Bank::where('status','1')->get();
            $locations = Location::where('status','1')->get();
            $designations = Designation::where('status','1')->get();
            $enquiries = Enquiry::with('designation:id,name','location:id,name','incentives:id,incentive,remarks,staff_id,created_at','services:id,service_type','reportTo:id,name')->get();
            return view('admin.enquiries.index',compact('staffs','locations','designations','services','users','banks','enquiries'));
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
            'email' => 'required|unique:staff'
        ]);
        DB::beginTransaction();
        try{
            $input = [];
            $input = $request->all();
            unset($input['service_id']);
            $input['employee_id'] = 'emp';
            $input['password'] = Hash::make($request->password);

            if($file=$request->file('resume')){

                $file_name=time().$file->getClientOriginalName();
                $file->move('uploads',$file_name);
                $input['resume'] = $file_name;
            }

            $aadhar = [];
            if($files=$request->file('aadhar')){
                foreach($files as $file){
                    $file_name=time().$file->getClientOriginalName();
                    $file->move('uploads',$file_name);
                    array_push($aadhar,$file_name);
                }
            }
            $input['aadhar'] =implode(',',$aadhar);

            $pan = [];
            if($files=$request->file('pan')){
                foreach($files as $file){
                    $file_name=time().$file->getClientOriginalName();
                    $file->move('uploads',$file_name);
                    array_push($pan,$file_name);
                }
            }
            $input['pan'] =implode(',',$pan);

            $exp_cert_name = [];
            if($files=$request->file('exp_cert')){
                foreach($files as $file){
                    $file_name=time().$file->getClientOriginalName();
                    $file->move('uploads',$file_name);
                    array_push($exp_cert_name,$file_name);
                }
            }
            $input['exp_cert'] =implode(',',$exp_cert_name);

            $qual_cert_name = [];
            if($files=$request->file('qual_cert')){
                foreach($files as $file){
                    $file_name=time().$file->getClientOriginalName();
                    $file->move('uploads',$file_name);
                    array_push($qual_cert_name,$file_name);
                }
            }
            $input['qual_cert'] =implode(',',$qual_cert_name);

            $input['permissions'] =implode(',',$input['permissions']);


             $staff=Staff::create($input);


             $update_staff = Staff::where('id', $staff->id)->first();
             $update_staff->employee_id = 'bh_emp_'.$staff->id;
             $update_staff->save();

            $service_data = [];
            $current_time = date("Y-m-d H:i:s");

            foreach($request->service_id as $s){
                $service_data[] = ['service_id'=>$s,'staff_id'=>$staff->id,'created_at'=>$current_time,'updated_at'=>$current_time];
            }
            StaffService::insert($service_data);

            DB::commit();
            return redirect()->back()
                ->with('success', 'Staff created successfully.');

        }catch(\Exception $e){
            DB::rollback();
            return Redirect::back()->with('error',$e->getMessage());
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


    public function save_staff_incentive(Request $request){
        try{
            DB::beginTransaction();
            $current_time = date("Y-m-d H:i:s");
                $data_to_insert[] = [
                    'staff_id'=>$request->staff_id,
                    'incentive'=>$request->incentive,
                    'remarks'=>$request->remarks,
                    'created_at'=>$current_time,
                    'updated_at'=>$current_time
                ];

            StaffIncentive::insert($data_to_insert);
            DB::commit();
            return redirect()->back()->with('success',"Staff Intensive data saved successfully!");
        }catch(Exception $e){
            DB::rollback();
            return redirect()->back()->with('error',$e->getMessage().",line:".$e->getLine());
        }
    }


    public function save_staff_target(Request $request){
        try{
            DB::beginTransaction();
            $current_time = date("Y-m-d H:i:s");
                $data_to_insert[] = [
                    'staff_id'=>$request->staff_id,
                    'target_amount'=>$request->target_amount,
                    'service_id'=>$request->service_id,
                    'business_target_id'=>$request->service_id,
                    'created_at'=>$current_time,
                    'updated_at'=>$current_time
                ];
           //return 'dkfsdlf';
            StaffBusinessTarget::insert($data_to_insert);
            DB::commit();
            return redirect()->back()->with('success',"Staff Business Target data saved successfully!");
        }catch(Exception $e){
            DB::rollback();
            return redirect()->back()->with('error',$e->getMessage().",line:".$e->getLine());
        }
    }


    public function getDeleteSelectedImages(Request $request){

        try{
            $image_name = $request->image_name;
            $user_id = $request->user_id;
            $user = User::where('id',$user_id)->first();

            $images_array = explode(',',$user->pan);

            $pos = array_search($image_name, $images_array);

            unset($images_array[$pos]);

            $new_images =implode(',',$images_array);

            User::where('id', $user_id)->update(array('pan' => $new_images));
            unlink(public_path().'/uploads/'.$image_name);

            return 'success';

        }catch(Exception $e){
            return $e->getMessage();
        }

    }



    public function updateStaff(Request $request, $id)
    {

        DB::beginTransaction();
        try{
            $input = [];
            $input = $request->all();
            unset($input['_method']);
            unset($input['_token']);
            unset($input['service_id']);

            $pan_name = [];
            $aadhar_name = [];
            $exp_cert_name = [];
            $qual_cert_name = [];
            $new_pan = '';
            $new_aadhar = '';
            $new_exp_cert = '';
            $new_qual_cert = '';

            $input['permissions'] =implode(',',$input['permissions']);

            $pre_staff = Staff::where('id',$id)->first();

            $input['password'] = is_null($request->password) ? $pre_staff->password : Hash::make($request->password);

            if($files=$request->file('pan')){
                foreach($files as $file){
                    $file_name=time().$file->getClientOriginalName();
                    $file->move('uploads/',$file_name);
                    array_push($pan_name,$file_name);
                }
                $new_pan =implode(',',$pan_name);
                $input['pan'] = $new_pan.','.$pre_staff->pan;

            }else{
                $input['pan'] = $pre_staff->pan;
            }

            if($files=$request->file('aadhar')){
                foreach($files as $file){
                    $file_name=time().$file->getClientOriginalName();
                    $file->move('uploads/',$file_name);
                    array_push($aadhar_name,$file_name);
                }
                $new_aadhar =implode(',',$aadhar_name);
                $input['aadhar'] = $new_aadhar.','.$pre_staff->aadhar;

            }else{
                $input['aadhar'] = $pre_staff->aadhar;
            }

            if($files=$request->file('exp_cert')){
                foreach($files as $file){
                    $file_name=time().$file->getClientOriginalName();
                    $file->move('uploads/',$file_name);
                    array_push($exp_cert_name,$file_name);
                }
                $new_exp_cert =implode(',',$exp_cert_name);
                $input['exp_cert'] = $new_exp_cert.','.$pre_staff->exp_cert;

            }else{
                $input['exp_cert'] = $pre_staff->exp_cert;
            }

            if($files=$request->file('qual_cert')){
                foreach($files as $file){
                    $file_name=time().$file->getClientOriginalName();
                    $file->move('uploads/',$file_name);
                    array_push($qual_cert_name,$file_name);
                }
                $new_qual_cert =implode(',',$qual_cert_name);
                $input['qual_cert'] = $new_qual_cert.','.$pre_staff->qual_cert;

            }else{
                $input['qual_cert'] = $pre_staff->qual_cert;
            }


            if(isset($input['resume'])){
                if($file=$request->file('resume')){
                    unlink(public_path().'/uploads/'.$pre_staff->resume);
                    $file_name=time().$file->getClientOriginalName();
                    $file->move('uploads/',$file_name);
                }

            }else{
                $input['resume'] = $pre_staff->resume;
            }

            $updated_staff=Staff::where('id',$id)->update($input);

            $service_data = [];
            $current_time = date("Y-m-d H:i:s");

            StaffService::where('staff_id',$id)->delete();

            foreach($request->service_id as $s){
                $service_data[] = ['service_id'=>$s,'staff_id'=>$id,'created_at'=>$current_time,'updated_at'=>$current_time];
            }
            StaffService::insert($service_data);

            DB::commit();
            return redirect()->back()
                ->with('success', 'Staff updated successfully.');

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
}
