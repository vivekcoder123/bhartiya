<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Service;
use App\Models\ServiceBank;
use App\Models\ServiceFormAttribute;
use App\Models\ServiceformField;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $banks = Bank::orderBy('name')->get(['id','name']);
            $attributes = ServiceFormAttribute::get(['id','name']);
            $services = Service::with('banks:id,name','fields:id,name,show_name')->select('id','service_type','min_tenure','max_tenure','status')->get()
            ->map(function($service) use($attributes){
                $new_service = array();
                $present_fields = $service->fields->pluck('id')->toArray();
                $attributes_data = [];
                $attributes->each(function($attribute) use($present_fields,&$attributes_data){
                    if(in_array($attribute->id,$present_fields)){
                        $attributes_data[] = ['available'=>1,'id'=>$attribute->id,'name'=>$attribute->name];
                    }else{
                        $attributes_data[] = ['available'=>0,'id'=>$attribute->id,'name'=>$attribute->name];
                    }
                });
                unset($service->fields);
                $new_service['data'] = $service;
                $new_service['fields'] = collect($attributes_data);
                return $new_service;
            });
            return view('admin.services.index',compact('banks','services'));
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
        try{

            $validator = Validator::make($request->all(),[
                'service_type' => 'required|unique:services',
                'banks_array' => 'required',
                'tenure_range' => 'required'
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $tenure_range = explode(";",$request->tenure_range);
            $min_tenure = $tenure_range[0];
            $max_tenure = $tenure_range[1];
            $service_data = [
                'service_type'=>$request->service_type,
                'min_tenure'=>$min_tenure,
                'max_tenure'=>$max_tenure
            ];
            DB::beginTransaction();
            $service = Service::create($service_data);
            $banks_array = $request->banks_array;
            $service_banks_data = [];
            $current_time = date("Y-m-d H:i:s");
            foreach($banks_array as $bank){
                $service_banks_data[] = ['bank_id'=>$bank,'service_id'=>$service->id,'created_at'=>$current_time,'updated_at'=>$current_time];
            }
            ServiceBank::insert($service_banks_data);
            DB::commit();
            return redirect()->back()->with('success',"Service data saved successfully!");

        }catch(Exception $e){
            DB::rollback();
            return redirect()->back()->with('error',$e->getMessage().",line:".$e->getLine());
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function save_service_form_fields(Request $request){
        try{
            DB::beginTransaction();
            $checkedFieldsArray = $request->checkedFieldsArray;
            $service_id = $request->service_id;
            $current_time = date("Y-m-d H:i:s");
            ServiceformField::where('service_id',$service_id)->delete();
            foreach($checkedFieldsArray as $field){
                $data_to_insert[] = [
                    'service_id'=>$service_id,
                    'service_form_attribute_id'=>$field,
                    'created_at'=>$current_time,
                    'updated_at'=>$current_time
                ];
            }
            ServiceformField::insert($data_to_insert);
            DB::commit();
            return redirect()->back()->with('success',"Service fields data saved successfully!");
        }catch(Exception $e){
            DB::rollback();
            return redirect()->back()->with('error',$e->getMessage().",line:".$e->getLine());
        }
    }
}
