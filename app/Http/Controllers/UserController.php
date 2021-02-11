<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        try{
            $users = User::orderBy('first_name')->get();

            return view('admin.users.index',compact('users'));
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
                'email' => 'required|unique:users',
                'mobile_number' => 'required|unique:users',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $input = [];
            $input = $request->all();

            $pan = [];
            if($files=$request->file('pan')){
                foreach($files as $file){
                    $file_name=time().$file->getClientOriginalName();
                    $file->move('uploads',$file_name); 
                    array_push($pan,$file_name); 
                }
            }
            $input['pan'] =implode(',',$pan);

            $input['password'] = Hash::make($request->password);

            User::create($input);
            return redirect()->back()->with('success',"User Created successfully!");

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

    

    public function updateUser(Request $request,$id)
    {
        try{

            $input = [];
            $input = $request->all();
            unset($input['_method']);
            unset($input['_token']);
            $pre_user = User::find($id);
            $input['password'] = is_null($request->password) ? $pre_user->password : Hash::make($request->password);

            $pan_name = [];
            $new_pan = '';
            $pre_user = User::where('id',$id)->first();
            if($files=$request->file('pan')){
                foreach($files as $file){
                    $file_name=time().$file->getClientOriginalName();
                    $file->move('uploads/',$file_name); 
                    array_push($pan_name,$file_name); 
                }
                $new_pan =implode(',',$pan_name);
                $input['pan'] = $new_pan.','.$pre_user->pan;
            }else{
                $input['pan'] = $pre_user->pan;
            }

            User::where('id',$id)->update($input);
            return redirect()->back()->with('success',"Service data update successfully!");

        }catch(Exception $e){
            DB::rollback();
            return redirect()->back()->with('error',$e->getMessage().",line:".$e->getLine());
        }
    }

    public function changeStatus(Request $request)
    {
        
      try{
            $id = $request->id;

             if(!User::where('id', $request->id)->exists()){
                throw new Exception("User not found!");
             }
             $user = User::where('id', $request->id)->first();
             $user->status = $user->status=='1'?'0':'1';
             $user->save();
             return $user->status;
        }catch(Exception $e){
            
             return $e->getMessage();
            
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
}

