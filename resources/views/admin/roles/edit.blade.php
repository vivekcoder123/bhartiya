@extends('layouts.admin')

@section('content')

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left mb-20">
            <h4 class="text-dark h4">Update Role</h4>
            
        </div>
        
    </div>
    <form class="form-horizontal"  action="{{ route('roles.update',$role) }}" method="POST">      
       @method('PUT')
       @csrf
        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Role Name</label>
            <div class="col-sm-12 col-md-10">
                <input class="form-control" type="text" value="{{$role->name}}" name="name" placeholder="Name">
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Select Permissions</label>
            <div class="col-sm-12 col-md-10">
                <select class="custom-select2 form-control" name="permissions[]" multiple="multiple" style="width: 100%;">
                    <option value="dashboard" {{in_array("dashboard",explode(',',$role->permissions))?"selected":""}}>Dashboard</option>
                    <option value="products" {{in_array("products",explode(',',$role->permissions))?"selected":""}}>Products</option>
                    <option value="orders" {{in_array("orders",explode(',',$role->permissions))?"selected":""}}>Orders</option>
                    <option value="users" {{in_array("users",explode(',',$role->permissions))?"selected":""}}>Users</option>
                    <option value="banners" {{in_array("banners",explode(',',$role->permissions))?"selected":""}}>Banners</option>
                    <option value="promos" {{in_array("promos",explode(',',$role->permissions))?"selected":""}}>Promo Codes</option>
                    <option value="roles" {{in_array("roles",explode(',',$role->permissions))?"selected":""}}>Roles</option>
                    <option value="transactions" {{in_array("transactions",explode(',',$role->permissions))?"selected":""}}>Transactions</option>
                    <option value="delivery-management" {{in_array("delivery-management",explode(',',$role->permissions))?"selected":""}}>Delivery Management</option>

                </select>
            </div>
        </div>

        <button class="btn btn-success" type="submit">Update</button>

    </form>
    
</div>

@stop

