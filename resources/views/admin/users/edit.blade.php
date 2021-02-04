@extends('layouts.admin')

@section('content')

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left mb-20">
            <h4 class="text-dark h4">Update User</h4>
            
        </div>
        
    </div>
    <form class="form-horizontal"  action="{{ route('users.update',$user) }}" method="POST">      
       @method('PUT')
       @csrf
        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Name</label>
            <div class="col-sm-12 col-md-10">
                <input class="form-control" type="text" value="{{$user->name}}" name="name" placeholder="Name">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Email</label>
            <div class="col-sm-12 col-md-10">
                <input class="form-control" type="email" value="{{$user->email}}" name="email" placeholder="Email">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Password</label>
            <div class="col-sm-12 col-md-10">
                <input class="form-control" type="password" name="password" placeholder="Password">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Phone</label>
            <div class="col-sm-12 col-md-10">
                <input class="form-control" type="number" value="{{$user->phone}}" name="phone" placeholder="Phone">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">City</label>
            <div class="col-sm-12 col-md-10">
                <input class="form-control" type="text" value="{{$user->city}}" name="city" placeholder="City">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Area</label>
            <div class="col-sm-12 col-md-10">
                <input class="form-control" type="text" value="{{$user->area}}" name="area" placeholder="Area">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Postal Code</label>
            <div class="col-sm-12 col-md-10">
                <input class="form-control" type="text" value="{{$user->pincode}}" name="pincode" placeholder="Pincode">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Select Roles</label>
            <div class="col-sm-12 col-md-10">
                <select class="custom-select2 form-control" name="role_id" style="width: 100%;">
                    
                    @foreach($roles as $role)
                    <option value="{{$role->id}}" {{$role->id==$user->role_id?"selected":""}}>{{$role->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Status</label>
            <div class="col-sm-12 col-md-10">
                <select class="custom-select2 form-control" name="status" style="width: 100%;">
                    
                    <option value="1" {{$user->status=='1'?'Selected': ''}}>Active</option>
                    <option value="0" {{$user->status=='0'?'Selected': ''}}>Not Active</option>
                    
                </select>
            </div>
        </div>

        <button class="btn btn-success" type="submit">Update</button>

    </form>
    
</div>

@stop

