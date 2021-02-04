@extends('layouts.admin')

@section('content')

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left mb-20">
            <h4 class="text-dark h4">Create Role</h4>
            
        </div>
        
    </div>
    <form class="form-horizontal" action="{{route('roles.store')}}" method="POST">
        @csrf
        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Role Name</label>
            <div class="col-sm-12 col-md-10">
                <input class="form-control" type="text" name="name" placeholder="Name">
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Select Permissions</label>
            <div class="col-sm-12 col-md-10">
                <select class="custom-select2 form-control" name="permissions[]" multiple="multiple" style="width: 100%;">
                    <option value="dashboard">Dashboard</option>
                    <option value="products">Products</option>
                    <option value="orders">Orders</option>
                    <option value="users">Users</option>
                    <option value="banners">Banners</option>
                    <option value="promos">Promo Codes</option>
                    <option value="roles">Roles</option>
                    <option value="transactions">Transactions</option>
                    <option value="delivery-management">Delivery Managements</option>
                </select>
            </div>
        </div>

        <button class="btn btn-success" type="submit">Create</button>

    </form>
    
</div>

@stop

