@extends('layouts.admin')

@section('css')
<style type="text/css">

  .cart-total {
  width: 100%;
  display: block;
  border: 1px solid rgba(0, 0, 0, 0.05);
  padding: 20px; }
  .cart-total h3 {
    font-size: 16px;
    margin-bottom: 20px; }
  .cart-total p {
    width: 100%;
    display: block; }
    .cart-total p span {
      display: block;
      width: 43%; }
    .cart-total p.total-price span {
      text-transform: uppercase; }
      .cart-total p.total-price span:last-child {
        color: #000000;
        font-weight: 600; }
  .cart-total hr {
    background: rgba(255, 255, 255, 0.1); }
</style>
@stop

@section('content')

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mt-3">
                <div class="card-body">
                    <div class="card-title">
                        Staffs List
                        <button style="float: right; font-weight: 900;" class="btn btn-primary  mb-2" type="button"  data-toggle="modal" data-target="#createStaffModal">
                            Create New Staff
                        </button>
                    </div>
                    
                    <div class="table-responsive">

                <table class="table table-bordered table-striped" id="datatable">
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Applied Service</th>
                            <th>Relationship Manager</th>
                            <th>Loan Amount Applied</th>
                            <th>Eligible Loan Amount</th>
                            <th>Time</th>
                            <th>Tenure</th>
                            <th>Applied Bank</th>
                            <th>Assigned Bank</th>
                            <th>User Details</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enquiries as $e)
                        <tr>
                            <td>
                                <i class="fa fa-edit btn btn btn-outline-success getEditStaffData" id="getEditStaffData" data-value="{{collect($e)}}" data-staff_id="{{$e->id}}"></i>   

                            </td>
                            <td>{{$e->id}}</td>
                            <td>{{$e->user->name}}</td>
                            <td>{{$e->service->service_type}}</td>
                            <td>{{$e->relationship_manager->name}}</td>
                            <td>{{$e->loan_amount}}</td>
                            <td>

                                <button type="button" class="btn btn-outline-purple btn-round dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Assingn Loan Amount<i class="mdi mdi-chevron-down"></i></button>

                                
                                <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 39px, 0px);">
                                        
                                          
                                            <a class="dropdown-item" href="#"></a>
                                         
                                        
                                    </div>
                            
                            </td>
                            <td>{{$e->time}}</td>
                            <td>{{$e->tenure}}</td>
                            <td>{{$e->bank->name}}</td>

                            <td><button type="button" class="btn btn-outline-secondary btn-round  assignBank" data-staff_id="{{$e->id}}"><i class="fa fa-eye"></i> Assign Bank </button></td>

                            <td><button type="button" class="btn btn-outline-dark btn-round viewdetails" data-values="{{$e}}" data-staff_id="{{$e->id}}">User Profile</button></td>
                                    
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="modal fade show" id="bankModal" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="exampleModalLabel">
            Assign Bank</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body ">
            <div class="card">                                       
                <div class="card-body"> 
                
                    <div class="slimscroll activity-scroll">
                            
                        <form class="needs-validation was-validated" action="{{url('/admin/save_enquiry_bank')}}" method="POST">
                            {{ csrf_field() }}
                            <div id="form-content" class="enquiryForm">
                                <select name="propose_bank_id" type="text" class="form-control" required>
                                    <option Selected Defalt value="0">Select</option>
                                @foreach($banks as $b)
                                    <option value="{{$b->id}}">{{$b->name}}</option>
                                @endforeach
                            </select>

                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>



<div class="modal fade show" id="loanModal" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="exampleModalLabel">Eligible Loan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body ">
            <div class="card">                                       
                <div class="card-body"> 
                    
                    <div class="slimscroll activity-scroll">
                            
                                
                        <form class="needs-validation was-validated" action="{{url('/admin/save_staff_loan')}}" method="POST">
                            {{ csrf_field() }}
                            <div id="form-content">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Amount</label>
                                    <div class="col-lg-9">
                                        <input name="eligible_loan_amount" type="text" class="form-control staffRquiredField" placeholder="Loan Amount" >
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>



<div class="modal fade show" id="detailsModal" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="exampleModalLabel">Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body ">
            <div class="card">                                       
                <div class="card-body"> 
                    <div class="detailsData">

                    </div>                    
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>


<div class="modal fade show" id="createStaffModal" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="exampleModalLabel">Create New Client Enquiry</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <form  action="{{route('enquiries.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                    
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtFirstNameBilling" class="col-lg-3 col-form-label">Name</label>
                            <div class="col-lg-9">

                                <select name="user_id" type="text" class="form-control">
                                    <option Selected Defalt value="0">Select</option>
                                    @foreach($users as $l)
                                    <option value="{{$l->id}}">{{$l->first_name}} {{$l->last_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Choose Service</label>
                            <div class="col-lg-9">

                                <select name="service_id" type="text" class="form-control">
                                    <option Selected Defalt value="0">Select</option>
                                    @foreach($services as $l)
                                    <option value="{{$l->id}}">{{$l->service-type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                </div><!--end row-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtCompanyBilling" class="col-lg-3 col-form-label">Employment_type</label>
                            <div class="col-lg-9">

                                <select name="location_id" type="text" class="form-control">
                                    <option Selected Defalt value="0">Select</option>
                                    
                                    <option value="Salary">Self Employed</option>
                                    <option value="Business">Business</option>
                                    
                                </select>
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtEmailAddressBilling" class="col-lg-3 col-form-label">Income/Month</label>
                            <div class="col-lg-9">
                                <input id="txtEmailAddressBilling" name="dob" type="date" class="form-control staffRquiredField" placeholder="DOB" >
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                </div><!--end row-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtAddress1Billing" class="col-lg-3 col-form-label">Permanent Address</label>
                            <div class="col-lg-9">
                                <textarea id="txtAddress1Billing" name="address" rows="4" class="form-control"></textarea>
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtAddress2Billing" class="col-lg-3 col-form-label">Current Address</label>
                            <div class="col-lg-9">
                                <textarea id="txtAddress2Billing" name="current_address" rows="4" class="form-control"></textarea>
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                </div><!--end row-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtCityBilling" class="col-lg-3 col-form-label">Emergency Contact</label>
                            <div class="col-lg-9">
                                <input id="txtCityBilling" name="emergency_contact" type="number" class="form-control" placeholder="Emergency Contact">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtStateProvinceBilling" class="col-lg-3 col-form-label">Blood Group</label>
                            <div class="col-lg-9">
                                <input id="txtStateProvinceBilling" name="blood_group" type="text" class="form-control" placeholder="Blood Group">
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                </div><!--end row-->


                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtTelephoneBilling" class="col-lg-3 col-form-label">Password</label>
                            <div class="col-lg-9">
                                <input name="password" type="password" class="form-control staffRquiredField" placeholder="password" >
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtFaxBilling" class="col-lg-3 col-form-label">Location</label>
                            <div class="col-lg-9">

                                <select name="location_id" type="text" class="form-control staffRquiredField" placeholder="Location" >
                                    <option Selected Defalt value="0">Select</option>
                                    @foreach($locations as $l)
                                    <option value="{{$l->id}}">{{$l->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                </div><!--end row-->

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtTelephoneBilling" class="col-lg-3 col-form-label">Qualification</label>
                            <div class="col-lg-9">
                                <input name="qualification" type="text" class="form-control" placeholder="Qualification">
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtFaxBilling" class="col-lg-3 col-form-label">Marital Status</label>
                            <div class="col-lg-9">

                                <select  name="marital_status" type="text" class="form-control staffRquiredField"  >
                                    <option Selected Defalt value="M">Select</option>
                                    <option value="S">Single</option>
                                    <option value="M">Maried</option>
                                </select>
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                </div><!--end row-->


                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtTelephoneBilling" class="col-lg-3 col-form-label">Family Members</label>
                            <div class="col-lg-9">
                                <input name="family_members" type="number" class="form-control" placeholder="No. of family members">
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtFaxBilling" class="col-lg-3 col-form-label">Anniversary</label>
                            <div class="col-lg-9">
                                <input name="anniversary" type="date" class="form-control" placeholder="Anniversary" >
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                </div>
            
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row ">
                            <label for="txtCompanyShipping" class="col-lg-3 col-form-label">PAN Card</label>
                            <div class="col-lg-9">
                            <input type="file" class="custom-file-input" name="pan[]" multiple>
                            <label class="custom-file-label" for="customFile">file</label>
                        </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                    <div class="col-md-6">
                        <div class="form-group row ">
                            <label for="txtCompanyShipping" class="col-lg-3 col-form-label">Aadhar Card</label>
                            <div class="col-lg-9">
                            <input type="file" class="custom-file-input" name="aadhar[]" multiple>
                            <label class="custom-file-label" for="customFile">file</label>
                        </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                </div><!--end row-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtCompanyShipping" class="col-lg-3 col-form-label">Date of Joining</label>
                            <div class="col-lg-9">
                                <input id="txtCompanyShipping" name="doj" type="date" class="form-control staffRquiredField" placeholder="DOJ" >
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtCompanyShipping" class="col-lg-3 col-form-label">Resume</label>
                            <div class="col-lg-9">
                            <input type="file" class="custom-file-input"  name="resume">
                            
                            <label class="custom-file-label" for="customFile">file</label>
                        </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                </div><!--end row-->

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row ">
                            <label for="txtCompanyShipping" class="col-lg-3 col-form-label">Experience Certificates</label>
                            <div class="col-lg-9">
                            <input type="file" class="custom-file-input" name="exp_cert[]" multiple>
                            <label class="custom-file-label" for="customFile">file</label>
                        </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                    <div class="col-md-6">
                        <div class="form-group row ">
                            <label for="txtCompanyShipping" class="col-lg-3 col-form-label">Qualification Certificates</label>
                            <div class="col-lg-9">
                            <input type="file" class="custom-file-input" name="qual_cert[]" multiple>
                            <label class="custom-file-label" for="customFile">file</label>
                        </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                </div><!--end row-->
           
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtNameCard" class="col-lg-3 col-form-label">Designation</label>
                            <div class="col-lg-9">

                                <select name="designation_id" type="text" class="form-control staffRquiredField" placeholder="Designation" required>
                                    <option Selected Defalt value="0">Select</option>
                                    @foreach($designations as $d)
                                    <option value="{{$d->id}}">{{$d->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="ddlCreditCardType" class="col-lg-3 col-form-label">Report To</label>
                            <div class="col-lg-9">

                                <select name="report_to_id" type="text" class="form-control staffRquiredField" placeholder="Report To Staff" required>
                                    <option Selected Defalt value="0">Select</option>
                                    @foreach($all_staffs as $l)
                                    <option value="{{$l->id}}">{{$l->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                </div><!--end row-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtCreditCardNumber" class="col-lg-3 col-form-label">Permissions</label>
                            <div class="col-lg-9">
                                <select name="permissions[]" type="text" class="select2 staffRquiredField mb-3 select2-multiple select2-hidden-accessible" multiple >
                                    
                                    <option value="staffs">Staff</option>
                                    <option value="services">Service</option>
                                    <option value="clients">Client</option>
                                    
                                </select>
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="ddlCreditCardType" class="col-lg-3 col-form-label">Services</label>
                            <div class="col-lg-9">

                                <select name="service_id[]" type="text" class="select2 staffRquiredField mb-3 select2-multiple select2-hidden-accessible" multiple >
                                    
                                    @foreach($services as $l)
                                    <option value="{{$l->id}}">{{$l->service_type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div><!--end form-group-->
                    </div>
                    
                </div><!--end row-->
                
                <div class="p-3">
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input">
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">Please Click on Submit to Create Staff</span>
                    </label>

                    <div class="p-3" id="staffFormError"></div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                   
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>


<div class="modal fade show" id="fieldsModal" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="exampleModalLabel">Fields</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="needs-validation was-validated" action="{{url('/admin/save_Staff_form_fields')}}" method="POST">
                {{ csrf_field() }}
                <div id="form-content">

                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>


<div class="modal" id="EditStaffModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update Staff</h4>
                <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                    <strong>Success!</strong> Staff was updated successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="EditStaffModalBody">
                    
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


@endsection

@section('js')

    <script>
       
        var services = {!! json_encode($services) !!};
        var allTargets = {!! json_encode($targets) !!};
        var allStaffs = {!! json_encode($all_staffs) !!};
        var designations = {!! json_encode($designations) !!};
        var locations = {!! json_encode($locations) !!};

        var AllPermissions = [
            {
                value:'services',
                text:'Services'
            },
            {
                value:'staffs',
                text:'Staffs'
            },
            {
                value:'clients',
                text:'Clients'
            }
        ];
        
        $(document).ready(function(){
            $("a[href$='#finish']").css("display", "none");
        });

        $('#datatable').DataTable();
        $(".viewBanks").on("click",function(){
            var data = $(this).data("values");
            var html = `<table class='table table-bordered table-striped'>
                <thead>
                    <tr>
                        <th>Bank Name</th>
                    </tr>
                </thead>
                <tbody>`;
            data.forEach(function(d){
                html += `<tr><td>${d.name}</td></tr>`;
            });
            html += "</tbody></table>";
            $("#banksModal .modal-body").html(html);
            $("#banksModal").modal("show");
        });

        $(".viewFields").on("click",function(){
            var data = $(this).data("values");
            var Staff_id = $(this).data("Staff_id");
            var html = `<input type="hidden" name="Staff_id" value="${Staff_id}">`;
            data.forEach(function(d){
                html += `<div class="form-group row">
                    <div class="col-sm-10 ml-auto">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="horizontalCheckbox${d.id}" data-parsley-multiple="groups" data-parsley-mincheck="2" ${d.available == 1?'checked':''} name="checkedFieldsArray[]" value="${d.id}">
                            <label class="custom-control-label" for="horizontalCheckbox${d.id}">${d.name}</label>
                        </div>
                    </div>
                </div>`;
            });
            console.log('modal',html);
            $("#fieldsModal .modal-body form #form-content").html(html);
            $("#fieldsModal").modal("show");
        });


        //delete Staff
        var deleteID;
        $('body').on('click', '#getDeleteId', function(){
            deleteID = $(this).data('id');
        })
        $('#SubmitDeleteStaffForm').click(function(e) {
            e.preventDefault();
            var id = deleteID;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "/admin/Staffs/"+id,
                method: 'DELETE',
                data:{"_token": "{{ csrf_token() }}"},
                success: function(result) {
                    console.log(result);
                    $('#DeleteStaffModal').modal('hide');
                    //window.location.reload();
                }
            });
        });


        $(document).on("click","#getUpdateId",function(){
                id = $(this).data('id');
                
                $.ajax({
                    method:'POST',
                    url:`/admin/Staffs/change-status`,
                    data:{id,"_token":"{{csrf_token()}}"}
                }).then(response=>{
                  if(response == '1'){
                    $('#updateMessage'+id).text('Active');
                    $('#StatusStaffModal').modal('show');
                    setInterval(function(){ 
                            $('#StatusStaffModal').modal('hide');
                    }, 4000);
                  }
                  if(response == '0'){
                    $('#updateMessage'+id).text('Not Active');
                    $('#StatusStaffModal').modal('show');
                    setInterval(function(){ 
                            $('#StatusStaffModal').modal('hide');
                    }, 4000);
                  }
                }).fail(error=>{
                    console.log('error',error);
                });
            });



        $(".viewIncentives").on("click",function(){
            var incentives = $(this).data("values");
            console.log(incentives);
            var staff_id = $(this).data("staff_id");
            
            var htmlList = '';
            var htmlForm = '';
            
            incentives.forEach(function(incentive){
                htmlList += `<div class="activity-info">
                                <div class="icon-info-activity">
                                    <i class="mdi mdi-checkbox-marked-circle-outline bg-soft-success"></i>
                                </div>
                                <div class="activity-info-text">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="m-0 w-75">${incentive.incentive}</h6>
                                        <span class="text-muted d-block">${incentive.created_at}</span>
                                        
                                    </div>
                                    <p class="text-muted mt-1">${incentive.remarks} 
                                    </p>
                                </div>
                            </div>`;
            });

            htmlForm += `<div class="col-md-12 mb-3">
                        <label for="validationCustom01">Incentive Amount</label>
                        <input type="number" class="form-control" id="validationCustom01" placeholder="Amount" name="incentive" required="">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter amount.</div>
                    </div>
                    <input type="hidden" value="${staff_id}" name="staff_id" >
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom02">Remarks</label>
                        <input type="text" class="form-control" id="validationCustom02" placeholder="Remarks" name="remarks" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter remarks.</div>
                    </div>`;

            $("#incentivesModal .incentivesList").html(htmlList);
            $("#incentivesModal .incentivesForm").html(htmlForm);
            
            $("#incentivesModal").modal("show");
        });


        $(".viewTargets").on("click",function(){
            var targets = $(this).data("values");
            var staff_services = $(this).data("service");
           
            var staff_id = $(this).data("staff_id");
            
            var htmlList = '';
            var htmlForm = '';
            
            targets.forEach(function(target){
                htmlList += `<div class="activity-info">
                                <div class="icon-info-activity">
                                    <i class="mdi mdi-checkbox-marked-circle-outline bg-soft-success"></i>
                                </div>
                                <div class="activity-info-text">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="m-0 w-75">${target.service.service_type}</h6>
                                        <span class="text-muted d-block">${target.created_at}</span>

                                    </div>
                                    <p class="text-muted mt-1">${target.target_amount} | ${target.business_target.name}
                                    </p>
                                </div>
                            </div>`;
            });

            htmlForm += `<div class="col-md-12 mb-3">
                        <label for="validationCustom01">Service</label>
                        <select class="form-control select2" name="service_id" id="validationCustom01" required="">`;


                         staff_services.forEach(function(d){
                            htmlForm += `<option value="${d.id}">${d.service_type}</option>`;
                        });



                htmlForm += `</select>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please select service.</div>
                    </div>`;


                htmlForm += `<div class="col-md-12 mb-3">
                        <label for="validationCustom02">Business Target</label>
                        <select class="form-control select2" name="business_target_id" id="validationCustom02" required="">`;


                         allTargets.forEach(function(t){
                            htmlForm += `<option value="${t.id}">${t.name}</option>`;
                        });

                htmlForm += `</select>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please select service.</div>
                    </div>
                    <input type="hidden" value="${staff_id}" name="staff_id" >
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom03">Target Amount</label>
                        <input type="number" class="form-control" id="validationCustom03" placeholder="Amount" name="target_amount" required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter target amount (optional).</div>
                    </div>`;

            $("#targetsModal .targetsList").html(htmlList);
            $("#targetsModal .targetsForm").html(htmlForm);
            
            $("#targetsModal").modal("show");
        });


    $(".viewdetails").on("click",function(){
        var d = $(this).data("values");
        console.log(d);
        var staff_id = $(this).data("staff_id");
        
        var htmlList =`<div class="cart-wrap ftco-animate">
                <div class="cart-total mb-3">
                  <h5>Persional Details</h5> 
                  <hr>
                  <p class="d-flex total-price">
                    <span>Email</span>
                    <span id="final_price">${d.email}</span>
                  </p>
                  <p class="d-flex total-price">
                    <span>Mobile Number</span>
                    <span id="final_price">${d.mobile_number}</span>
                  </p>
                  <p class="d-flex total-price">
                    <span>Address</span>
                    <span id="final_price">${d.address}</span>
                  </p>
                  <p class="d-flex total-price">
                    <span>Location</span>
                    <span id="final_price">${d.location.name}</span>
                  </p>
                  <p class="d-flex total-price">
                    <span>Emergency Contact</span>
                    <span id="final_price">${d.emergency_contact}</span>
                  </p>
                  <p class="d-flex total-price">
                    <span>Current Address</span>
                    <span id="final_price">${d.current_address}</span>
                  </p>
                  <p class="d-flex total-price">
                    <span>Blook Group</span>
                    <span id="final_price">${d.blood_group}</span>
                  </p>
                  <p class="d-flex total-price">
                    <span>Qualification</span>
                    <span id="final_price">${d.qualification}</span>
                  </p>
                  <p class="d-flex total-price">
                    <span>Date Of Birth</span>
                    <span id="final_price">${d.dob}</span>
                  </p>
                  <p class="d-flex total-price">
                    <span>PAN</span>
                    <span id="final_price">${d.pan}</span>
                  </p>
                  <p class="d-flex total-price">
                    <span>Aadhar.</span>
                    <span id="final_price">${d.aadhar}</span>
                  </p>
                  <p class="d-flex total-price">
                    <span>Marital Status</span>
                    <span id="final_price">${d.marital_status}</span>
                  </p>
                  <p class="d-flex total-price">
                    <span>Family Members</span>
                    <span id="final_price">${d.family_members}</span>
                  </p>
                  <p class="d-flex total-price">
                    <span>Anniversary</span>
                    <span id="final_price">${d.anniversary}</span>
                  </p>
                </div>
                
              </div>`;
      
        $("#detailsModal .detailsData").html(htmlList);
        
        $("#detailsModal").modal("show");
    });

    function staffFormSubmit(){
        // e.preventDefault();
        var arr = $('.staffRquiredField').map((i, e) => {
            if(!e.value && $(e).attr("placeholder")){
                var sd = $(e).attr('placeholder');
                return '*'+sd+' '+'is required!';
            }
        }).get();
        if(arr.length>0){
            var vPool="";
            jQuery.each(arr, function(i, val) {
                vPool += `<div class="text-danger font-weight-bold mb-1">${val}</div>`;
            });

            
            if(jQuery("select[name=permissions]").length == 0) {
                vPool += `<div class="text-danger font-weight-bold mb-1">*Permissions is required!</div>`;
            }
            if(jQuery("select[name=service_id]").length == 0) {
                vPool += `<div class="text-danger font-weight-bold mb-1">*Services is required!</div>`;
            }
            if(jQuery("select[name=designation_id]").val() == 0) {
                vPool += `<div class="text-danger font-weight-bold mb-1">*Designation is required!</div>`;
            }
            if(jQuery("select[name=report_to_id]").val() == 0) {
                vPool += `<div class="text-danger font-weight-bold mb-1">*Report to Staff is required!</div>`;
            }
            if(jQuery("select[name=location_id]").val() == 0) {
                vPool += `<div class="text-danger font-weight-bold mb-1">*Location is required!</div>`;
            }
            $('#staffFormError').html(vPool);
            
            return false;
        }

        return true;
    }


     function staffUpdateFormSubmit(){

        var arr = $('.staffRquiredField1').map((i, e) => {
            if(!e.value && $(e).attr("placeholder")){
                var sd = $(e).attr('placeholder');
                return '*'+sd+' '+'is required!';
            }
        }).get();
        if(arr.length>0){
            var vPool="";
            jQuery.each(arr, function(i, val) {
                vPool += `<div class="text-danger font-weight-bold mb-1">${val}</div>`;
            });

            
            if($("#updatePermissions").length == 0) {
                vPool += `<div class="text-danger font-weight-bold mb-1">*Permissions is required!</div>`;
            }
            if($("#updateServiceId").length == 0) {
                vPool += `<div class="text-danger font-weight-bold mb-1">*Services is required!</div>`;
            }
            if($("#updateDesignationId").val() == 0) {
                vPool += `<div class="text-danger font-weight-bold mb-1">*Designation is required!</div>`;
            }
            if($("#updateReportToId").val() == 0) {
                vPool += `<div class="text-danger font-weight-bold mb-1">*Report to Staff is required!</div>`;
            }
            if($("#updateLocationId").val() == 0) {
                vPool += `<div class="text-danger font-weight-bold mb-1">*Location is required!</div>`;
            }
            $('#staffFormError1').html(vPool);
            
            return false;
        }

        return true;
    }


        $(".getEditStaffData").on("click",function(){
            var staff = $(this).data("value");
            var staff_id = $(this).data("staff_id");

            var staffPermissions = staff.permissions.split(',');
            var services_id = staff.services.map(function(service){
                return service.id;
            })
            
            var html = `<form id="form-horizontal1" onsubmit="return staffUpdateFormSubmit()" class="form-horizontal form-wizard-wrapper" action="{{url('admin/staffs/update/${staff_id}')}}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                

                <h3>Personal Details</h3>
                    <fieldset>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="txtFirstNameBilling" class="col-lg-3 col-form-label">Name</label>
                                    <div class="col-lg-9">
                                        <input id="txtFirstNameBilling" name="name" type="text" class="form-control staffRquiredField1" placeholder="Name" value="${staff.name}">
                                    </div>
                                </div><!--end form-group-->
                            </div><!--end col-->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Mobile No.</label>
                                    <div class="col-lg-9">
                                        <input id="txtLastNameBilling" name="mobile_number" type="" class="form-control staffRquiredField1" placeholder="Mobile Number" value="${staff.mobile_number}">
                                    </div>
                                </div><!--end form-group-->
                            </div><!--end col-->
                        </div><!--end row-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="txtCompanyBilling" class="col-lg-3 col-form-label">Email</label>
                                    <div class="col-lg-9">
                                        <input id="txtCompanyBilling" name="email" type="email" class="form-control staffRquiredField1" placeholder="Email" value="${staff.email}">
                                    </div>
                                </div><!--end form-group-->
                            </div><!--end col-->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="txtEmailAddressBilling" class="col-lg-3 col-form-label">Date of Birth</label>
                                    <div class="col-lg-9">
                                        <input id="txtEmailAddressBilling" name="dob" type="date" class="form-control staffRquiredField1" placeholder="DOB" value="${staff.dob}">
                                    </div>
                                </div><!--end form-group-->
                            </div><!--end col-->
                        </div><!--end row-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="txtAddress1Billing" class="col-lg-3 col-form-label">Permanent Address</label>
                                    <div class="col-lg-9">
                                        <textarea id="txtAddress1Billing" name="address" rows="4" class="form-control">${staff.address}</textarea>
                                    </div>
                                </div><!--end form-group-->
                            </div><!--end col-->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="txtAddress2Billing" class="col-lg-3 col-form-label">Current Address</label>
                                    <div class="col-lg-9">
                                        <textarea id="txtAddress2Billing" name="current_address" rows="4" class="form-control">${staff.current_address}</textarea>
                                    </div>
                                </div><!--end form-group-->
                            </div><!--end col-->
                        </div><!--end row-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="txtCityBilling" class="col-lg-3 col-form-label">Emergency Contact</label>
                                    <div class="col-lg-9">
                                        <input id="txtCityBilling" name="emergency_contact" type="number" class="form-control" placeholder="Emergency Contact" value="${staff.emergency_contact}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="txtStateProvinceBilling" class="col-lg-3 col-form-label">Blood Group</label>
                                    <div class="col-lg-9">
                                        <input id="txtStateProvinceBilling" name="blood_group" type="text" class="form-control" placeholder="Blood Group" value="${staff.blood_group}">
                                    </div>
                                </div><!--end form-group-->
                            </div><!--end col-->
                        </div><!--end row-->


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="txtTelephoneBilling" class="col-lg-3 col-form-label">Password</label>
                                    <div class="col-lg-9">
                                        <input name="password" type="password" class="form-control staffRquiredField1" placeholder="password" value="${staff.password}">
                                    </div>
                                </div><!--end form-group-->
                            </div><!--end col-->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="txtFaxBilling" class="col-lg-3 col-form-label">Location</label>
                                    <div class="col-lg-9">

                                        <select name="location_id" type="text" class="form-control staffRquiredField1" placeholder="Location" id="updateLocationId">
                                            <option Selected Defalt value="0">Select</option>`;

                        locations.forEach(function(d){
                            html += `<option value="${d.id}" ${staff.location_id==d.id?'selected':''}>${d.name}</option>`;
                        });

                        html+=`</select>
                                    </div>
                                </div><!--end form-group-->
                            </div><!--end col-->
                        </div><!--end row-->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="txtTelephoneBilling" class="col-lg-3 col-form-label">Qualification</label>
                                    <div class="col-lg-9">
                                        <input name="qualification" type="text" class="form-control" placeholder="Qualification" value="${staff.qualification}">
                                    </div>
                                </div><!--end form-group-->
                            </div><!--end col-->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="txtFaxBilling" class="col-lg-3 col-form-label">Marital Status</label>
                                    <div class="col-lg-9">

                                        <select  name="marital_status" type="text" class="form-control staffRquiredField1"  >
                                            <option Selected Defalt value="M">Select</option>
                                            <option value="S" ${staff.marital_status=='S'?'Selected':''}>Single</option>
                                            <option value="M" ${staff.marital_status=='M'?'Selected':''}>Maried</option>
                                        </select>
                                    </div>
                                </div><!--end form-group-->
                            </div><!--end col-->
                        </div><!--end row-->


                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="txtTelephoneBilling" class="col-lg-3 col-form-label">Family Members</label>
                                    <div class="col-lg-9">
                                        <input name="family_members" type="number" class="form-control" placeholder="No. of family members" ${staff.family_members}>
                                    </div>
                                </div><!--end form-group-->
                            </div><!--end col-->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="txtFaxBilling" class="col-lg-3 col-form-label">Anniversary</label>
                                    <div class="col-lg-9">
                                        <input name="anniversary" type="date" class="form-control" placeholder="Anniversary" ${staff.anniversary}>
                                    </div>
                                </div><!--end form-group-->
                            </div><!--end col-->
                        </div>
                    </fieldset><!--end fieldset-->

                    <h3>Document</h3>
                    <fieldset>
                    <div class="row">
                            <div class="col-md-6">
                            <div class="form-group row ">
                                    <label for="txtCompanyShipping" class="col-lg-3 col-form-label">PAN Card</label>
                                    <div class="col-lg-9">
                                    <input type="file" class="custom-file-input" name="pan[]" multiple>
                                    <label class="custom-file-label" for="customFile">file</label>
                                </div>
                                </div><!--end form-group-->
                            </div><!--end col-->
                            <div class="col-md-6">

                                <div class="form-group row ">
                                    <label for="txtCompanyShipping" class="col-lg-3 col-form-label">Aadhar Card</label>
                                    <div class="col-lg-9">
                                    <input type="file" class="custom-file-input" name="aadhar[]" multiple>
                                    <label class="custom-file-label" for="customFile">file</label>
                                </div>
                                </div><!--end form-group-->
                            </div><!--end col-->
                        </div><!--end row-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="txtCompanyShipping" class="col-lg-3 col-form-label">Date of Joining</label>
                                    <div class="col-lg-9">
                                        <input id="txtCompanyShipping" name="doj" type="date" class="form-control staffRquiredField1" placeholder="DOJ" value="${staff.doj}">
                                    </div>
                                </div><!--end form-group-->
                            </div><!--end col-->
                            <div class="col-md-6">

                                <div class="form-group row">
                                    <label for="txtCompanyShipping" class="col-lg-3 col-form-label">Resume</label>
                                    <div class="col-lg-9">
                                    <input type="file" class="custom-file-input"  name="resume">
                                    
                                    <label class="custom-file-label" for="customFile">file</label>

                                </div>
                                </div><!--end form-group-->
                            </div><!--end col-->
                        </div><!--end row-->

                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group row ">
                                    <label for="txtCompanyShipping" class="col-lg-3 col-form-label">Experience Certificates</label>
                                    <div class="col-lg-9">
                                    <input type="file" class="custom-file-input" name="exp_cert[]" multiple>
                                    <label class="custom-file-label" for="customFile">file</label>
                                </div>
                                </div><!--end form-group-->
                            </div><!--end col-->
                            <div class="col-md-6">
                             
                              <div class="form-group row ">
                                    <label for="txtCompanyShipping" class="col-lg-3 col-form-label">Qualification Certificates</label>
                                    <div class="col-lg-9">
                                    <input type="file" class="form-control-file form-control" name="qual_cert[]" multiple>
                                    <label class="custom-file-label" for="customFile">file</label>
                                </div>
                                </div><!--end form-group-->
                            </div><!--end col-->
                        </div><!--end row-->`;

                          if(staff.pan.length>0){
                            var pan = staff.pan.split(',');
                            
                            pan.map((i, e) => {

                            html+=`
                            <div class="row my-3">
                                <div class=" col-md-5">PAN Document- ${e+1}</div>
                                    <div class=" col-md-7">
                                        <div class="d-flex flex-row">
                                          <div class="col-md-8">
                                            <img src="{{ asset('uploads/${i}') }}" class="img-fluid" width="70px">
                                          </div>
                                          <div class="col-md-4">
                                            <input type="" class="get_product_id" value="${staff.id}" hidden>
                                            <button class="btn btn-danger deleteImage" id="${i}" type="button" data-value="pan">Remove</button>
                                          </div>
                                        </div>
                                    </div>
                                </div>`;
                            })
                            
                            
                          }
                          

                          if(staff.aadhar.length>0){
                            var aadhar = staff.aadhar.split(',');
                            
                            aadhar.map((i, e) => {

                            html+=`
                            <div class="row my-3">
                                <div class=" col-md-5">Aadhar Document-${e+1}</div>
                                    <div class=" col-md-7">
                                        <div class="d-flex flex-row">
                                          <div class="col-md-8">
                                            <img src="{{ asset('uploads/${i}') }}" class="img-fluid" width="70px">
                                          </div>
                                          <div class="col-md-4">
                                            <input type="" class="get_product_id" value="${staff.id}" hidden>
                                            <button class="btn btn-danger deleteImage" id="${i}" type="button" data-value="aadhar">Remove</button>
                                          </div>
                                        </div>
                                    </div>
                                </div>`;
                            })
                            
                            
                          }
                          

                          if(staff.resume){
                            
                            html+=`
                            <div class="row my-3">
                                <div class=" col-md-5">Resume</div>
                                    <div class=" col-md-7">
                                        <div class="d-flex flex-row">
                                          <div class="col-md-8">
                                            <img src="{{ asset('uploads/${staff.resume}') }}" class="img-fluid" width="70px">
                                          </div>
                                          <div class="col-md-4">
                                            <input type="" class="get_product_id" value="${staff.id}" hidden>
                                            <button class="btn btn-danger deleteImage" id="${staff.resume}" type="button" data-value="resume">Remove</button>
                                          </div>
                                        </div>
                                    </div>
                                </div>`;
                            
                          }
                          

                          if(staff.exp_cert.length>0){
                            var exp_cert = staff.exp_cert.split(',');
                            
                            exp_cert.map((i, e) => {

                            html+=`
                            <div class="row my-3">
                                <div class=" col-md-5">Experience Document-${e+1}</div>
                                    <div class=" col-md-7">
                                        <div class="d-flex flex-row">
                                          <div class="col-md-8">
                                            <img src="{{ asset('uploads/${i}') }}" class="img-fluid" width="70px">
                                          </div>
                                          <div class="col-md-4">
                                            <input type="" class="get_product_id" value="${staff.id}" hidden>
                                            <button class="btn btn-danger deleteImage" id="${i}" type="button" data-value="exp_cert">Remove</button>
                                          </div>
                                        </div>
                                    </div>
                                </div>`;
                            })
                            
                            
                          }
                          

                          if(staff.qual_cert.length>0){
                            var qual_cert = staff.qual_cert.split(',');
                            
                            qual_cert.map((i, e) => {

                            html+=`
                            <div class="row my-3">
                                <div class=" col-md-5">Qualification Document-${e+1}</div>
                                    <div class=" col-md-7">
                                        <div class="d-flex flex-row">
                                          <div class="col-md-8">
                                            <img src="{{ asset('uploads/${i}') }}" class="img-fluid" width="70px">
                                          </div>
                                          <div class="col-md-4">
                                            <input type="" class="get_product_id" value="${staff.id}" hidden>
                                            <button class="btn btn-danger deleteImage" id="${i}" type="button" data-value="qual_cert">Remove</button>
                                          </div>
                                        </div>
                                    </div>
                                </div>`;
                            })
                            
                            
                          }
                          


                html+=`
                    </fieldset><!--end fieldset-->

                    <h3>Company Profile</h3>
                    <fieldset>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="txtNameCard" class="col-lg-3 col-form-label">Designation</label>
                                    <div class="col-lg-9">

                                        <select name="designation_id" class="form-control staffRquiredField1" placeholder="Designation" id="updateDesignationId" required>
                                            <option Selected Defalt value="0">Select</option>`;

                        designations.forEach(function(d){
                            html += `<option value="${d.id}" ${staff.designation_id==d.id?'selected':''}>${d.name}</option>`;
                        });

                        html+=`</select>
                                    </div>
                                </div><!--end form-group-->
                            </div><!--end col-->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="ddlCreditCardType" class="col-lg-3 col-form-label">Report To</label>
                                    <div class="col-lg-9">

                                        <select name="report_to_id" class="form-control staffRquiredField1" id="updateReportToId" placeholder="Report To Staff" required>
                                            <option Selected Defalt value="0">Select</option>`;

                        allStaffs.forEach(function(d){
                            html += `<option value="${d.id}" ${staff.report_to_id==d.id?'selected':''}>${d.name}</option>`;
                        });

                        html+=`</select>
                                    </div>
                                </div><!--end form-group-->
                            </div><!--end col-->
                        </div><!--end row-->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="txtCreditCardNumber" class="col-lg-3 col-form-label">Permissions</label>
                                    <div class="col-lg-9">
                                        <select name="permissions[]" id="updatePermissions" type="text" class="select2 staffRquiredField1 mb-3" multiple >
                                            
                                            
                                            
                                            
                                        </select>
                                    </div>
                                </div><!--end form-group-->
                            </div><!--end col-->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label for="ddlCreditCardType" class="col-lg-3 col-form-label">Services</label>
                                    <div class="col-lg-9">

                                        <select name="service_id[]" id="updateServiceId" type="text" class="select2 staffRquiredField1 mb-3" multiple >`;

                        services.forEach(function(d){
                            html += `<option value="${d.id}" ${services_id.includes(d.id)?'selected':''}>${d.service_type}</option>`;
                        });

                        html+=`</select>
                                    </div>
                                </div><!--end form-group-->
                            </div>
                            
                        </div><!--end row-->
                        
                    </fieldset><!--end fieldset-->

                    <h3>Confirm Detail</h3>
                    <fieldset>
                        <div class="p-3">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Please Click on Submit to Create Staff</span>
                            </label>

                            <div class="p-3" id="staffFormError1"></div>

                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                        
                    </fieldset><!--end fieldset-->


                </form>`;
          
            $("#EditStaffModal .modal-body #EditStaffModalBody").html(html);
            $(".select2").select2();
            $(".select2").select2();

            $("#form-horizontal1").steps({
                headerTag: "h3",
                bodyTag: "fieldset",
                transitionEffect: "slide"
            });
            
            $("#EditStaffModal").modal("show");
        });
    
       



    $(document).on("click",".deleteImage",function(){
        const el = this;
        const staff_id = $('.get_product_id').val();
        const image_name=this.id;
        const doc_type = $(this).data("value");
        $.ajax({
            method:'POST',
            url:`/admin/staffs/getDeleteSelectedImages`,
            data:{image_name,staff_id,doc_type,"_token":"{{csrf_token()}}"},
            encode  : true
        }).then(response=>{
            console.log(response);
            if(response){
                 $(el).parent().parent().parent().parent().css('background','tomato');
                 $(el).parent().parent().parent().parent().fadeOut(function(){
                    $(this).remove();
                 });            
            }
        }).fail(error=>{
            console.log('error',error);
        });
    });

    </script>


@endsection
