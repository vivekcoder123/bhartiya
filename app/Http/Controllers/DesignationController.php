<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Designation;
use Exception;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.Designations.index');
    }

    public function getDesignations(Request $request, Designation $designation)
    {
        $data = $designation->getData();
        return \DataTables::of($data)
            ->addColumn('status', function($data) {
                return $data->status=='1'?'Active':'Not Active';
            })->addColumn('Actions', function($data) {
                return '<button type="button" class="btn btn-success btn-sm" id="getEditDesignationData" data-id="'.$data->id.'"><i class="fa fa-edit"> Edit</i></button>
                    <button type="button" class="btn btn-warning btn-sm " id="getUpdateId" data-id="'.$data->id.'"><i class="ti-loop"> Change Status</i></button>';
            })
            ->rawColumns(['Actions'])
            ->make(true);
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
    public function store(Request $request, Designation $designation)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $designation->storeData($request->all());

        return response()->json(['success'=>'Designation added successfully']);
    
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
        $designation = new Designation;
        $data = $designation->findData($id);

        $html = '<div class="form-group">
                    <label for="Name">Name:</label>
                    <input type="text" class="form-control" name="name" id="editDesignation" value="'.$data->name.'">
                </div>';

        return response()->json(['html'=>$html]);
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
        $validator = \Validator::make($request->all(), [
            'name' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $designation = new Designation;
        $designation->updateData($id, $request->all());

        return response()->json(['success'=>'Designation updated successfully']);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $designation = new Designation;
    //     $designation->deleteData($id);

    //     return response()->json(['success'=>'Designation deleted successfully']);
    // }

    public function changeStatus(Request $request)
    {
        
      try{
            $id = $request->id;

         if(!Designation::where('id', $request->id)->exists()){
            throw new Exception("Designation not found!");
         }
         $designation = Designation::where('id', $request->id)->first();
         $designation->status = $designation->status=='1'?'0':'1';
         $designation->save();
         return $designation->status;
        }catch(Exception $e){
            
            return $e->getMessage();
            
        }

       
    }
}
