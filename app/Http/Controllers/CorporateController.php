<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Corporate;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CorporateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $locations = Location::where('status','1')->get();
            $corporates = Corporate::with('location:id,name')->get();
            return view('admin.corporate.index',compact('locations','corporates'));
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
            
            $corporate = new Corporate();
            $corporate->product_head = $request->product_head;
            $corporate->company_name = $request->company_name;
            $corporate->employee_strength = $request->employee_strength;
            $corporate->location_id = $request->location_id;
            $corporate->name = $request->name;
            $corporate->mobile_number = $request->mobile_number;
            $corporate->designation = $request->designation;
            $corporate->note = $request->note;

            $corporate->save();

            return redirect()->back()
                ->with('success', 'Corporate created successfully.');

        }catch(\Exception $e){
           
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


    public function updateCorporate(Request $request, $id)
    {    
        try{
            $input = [];
            $input = $request->all();
            unset($input['_method']);
            unset($input['_token']);
   
            Corporate::where('id',$id)->update($input);

            return redirect()->back()
                ->with('success', 'Corporate updated successfully.');

        }catch(\Exception $e){
            DB::rollback();
            return Redirect::back()->with('error',$e->getMessage());
        }
    }

    public function change_corporate_status(Request $request){
        try{

            $corporate = Corporate::find($request->corporate_id);
            $corporate->status = $request->status;
            $corporate->save();

            return redirect()->back()->with('success',"Corporate Status Updated successfully!");
        }catch(Exception $e){
            return redirect()->back()->with('error',$e->getMessage().",line:".$e->getLine());
        }
    }

}
