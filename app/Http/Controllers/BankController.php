<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.banks.index');
    }

    public function getBanks(Request $request, Bank $bank)
    {
        $data = $bank->getData();
        return \DataTables::of($data)
            ->addColumn('status', function($data) {
                return $data->status=='1'?'Active':'Not Active';
            })->addColumn('Actions', function($data) {
                return '<button type="button" class="btn btn-success btn-sm" id="getEditBankData" data-id="'.$data->id.'"><i class="fa fa-edit"> Edit</i></button>
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
    public function store(Request $request, Bank $bank)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required'
        ]);
        
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $bank->storeData($request->all());

        return response()->json(['success'=>'Bank added successfully']);
    
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
        $bank = new Bank;
        $data = $bank->findData($id);

        $html = '<div class="form-group">
                    <label for="Name">Name:</label>
                    <input type="text" class="form-control" name="name" id="editBank" value="'.$data->name.'">
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

        $bank = new Bank;
        $bank->updateData($id, $request->all());

        return response()->json(['success'=>'Bank updated successfully']);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     $bank = new Bank;
    //     $bank->deleteData($id);

    //     return response()->json(['success'=>'Bank deleted successfully']);
    // }

    public function changeStatus(Request $request)
    {
        
      try{
            $id = $request->id;

         if(!Bank::where('id', $request->id)->exists()){
            throw new Exception("Bank not found!");
         }
         $bank = Bank::where('id', $request->id)->first();
         $bank->status = $bank->status=='1'?'0':'1';
         $bank->save();
         return $bank->status;
        }catch(Exception $e){
            
            return $e->getMessage();
            
        }

       
    }
}
