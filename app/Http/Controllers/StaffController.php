<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Service;
use App\Models\Location;
use App\Models\Designation;
use App\Models\StaffBusiness;
use App\Models\StaffIncentive;
use App\Models\StaffService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class StaffController extends Controller
{                                                          
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $services = Service::orderBy('service_type')->get(['id','service_type']);
            $locations = Location::orderBy('name')->get();
            $designations = Designation::orderBy('name')->get();
            $staffs = Staff::with('designation:id,name','location:id,name','incentives:id,incentive,remarks,staff_id','services:id,service_type','targets:id,name','reportTo:id,name')->orderBy('name')->get();
            //return $staffs;
            return view('admin.staffs.index',compact('staffs','locations','designations','services'));
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
        //
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

    public function save_staff_intensive(Request $request){
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
}
