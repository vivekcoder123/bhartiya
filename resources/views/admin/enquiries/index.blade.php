

@extends('layouts.admin')

@section('css')

<link href="{{asset('plugins/ion-rangeslider/ion.rangeSlider.css')}}" rel="stylesheet" type="text/css"/>
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
                        Enquiries List
                        <button style="font-weight: 900;" class="btn btn-primary  mb-2" type="button"  data-toggle="modal" data-target="#createEnquiryModal">
                            Create New Enquiry
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
                            <th>Status</th>
                            <th>Activity</th>
                            <th>Existing Loans</th>
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


<div class="modal fade show" id="createEnquiryModal" tabindex="-1" role="dialog" >
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
                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Choose Service</label>
                            <div class="col-lg-9">

                                <select name="service_id" id="service_id" class="form-control select2" required>
                                    <option Selected Defalt value="0">Select</option>
                                    @foreach($services as $service)
                                    <option value="{{$service->id}}">{{$service->service_type}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Choose User</label>
                            <div class="col-lg-9">

                                <select name="user_id" type="text" class="form-control select2" required>
                                    <option Selected Defalt value="0">Select</option>
                                    @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->first_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtCompanyBilling" class="col-lg-3 col-form-label">Employment Type</label>
                            <div class="col-lg-12">

                                <select name="location_id" type="text" class="form-control select2">
                                    <option Selected Defalt value="0">Select</option>

                                    <option value="Salary">Self Employed</option>
                                    <option value="Business">Business</option>

                                </select>
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtEmailAddressBilling" class="col-lg-3 col-form-label">Monthly Income</label>
                            <div class="col-lg-9">
                                <input id="txtEmailAddressBilling" name="salary_month" type="number" class="form-control staffRquiredField" placeholder="DOB" >
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                </div><!--end row-->


                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtFaxBilling" class="col-lg-3 col-form-label">Relationship Manager</label>
                            <div class="col-lg-9">

                                <select name="relationship_manager_id" class="form-control select2" required>
                                    <option Selected Defalt value="0">Select</option>
                                    @foreach($staffs as $staff)
                                    <option value="{{$staff->id}}">{{$staff->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                    <!--end col-->
                </div><!--end row-->

                <div class="row" id="dynamic_data">

                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row ">
                            <label for="txtCompanyShipping" class="col-lg-3 col-form-label">PAN Card</label>
                            <div class="col-lg-9">
                                <input type="file" class="custom-file-input" name="pan[]" multiple>
                                <label class="custom-file-label" for="customFile">Upload Files</label>
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                    <div class="col-md-6">
                        <div class="form-group row ">
                            <label for="txtCompanyShipping" class="col-lg-3 col-form-label">Aadhar Card</label>
                            <div class="col-lg-9">
                            <input type="file" class="custom-file-input" name="aadhar[]" multiple>
                            <label class="custom-file-label" for="customFile">Upload Files</label>
                        </div>
                        </div><!--end form-group-->
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row ">
                            <label for="txtCompanyShipping" class="col-lg-3 col-form-label">Address Proof</label>
                            <div class="col-lg-9">
                            <input type="file" class="custom-file-input" name="address_proof[]" multiple>
                            <label class="custom-file-label" for="customFile">Upload Files</label>
                        </div>
                        </div><!--end form-group-->
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row ">
                            <label for="txtCompanyShipping" class="col-lg-3 col-form-label">Payslip</label>
                            <div class="col-lg-9">
                            <input type="file" class="custom-file-input" name="payslip[]" multiple>
                            <label class="custom-file-label" for="customFile">Upload Files</label>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row ">
                            <label for="txtCompanyShipping" class="col-lg-3 col-form-label">Return Statement</label>
                            <div class="col-lg-9">
                            <input type="file" class="custom-file-input" name="return_statement[]" multiple>
                            <label class="custom-file-label" for="customFile">Upload Files</label>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row ">
                            <label for="txtCompanyShipping" class="col-lg-3 col-form-label">Bank Statement</label>
                            <div class="col-lg-9">
                            <input type="file" class="custom-file-input" name="bank_statement[]" multiple>
                            <label class="custom-file-label" for="customFile">Upload Files</label>
                        </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row ">
                            <label for="txtCompanyShipping" class="col-lg-3 col-form-label">Other Documents</label>
                            <div class="col-lg-9">
                            <input type="file" class="custom-file-input" name="others[]" multiple>
                            <label class="custom-file-label" for="customFile">Upload Files</label>
                        </div>
                        </div>
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



        $(document).on("change","#service_id",function(){
            const service_id = $(this).val();
            $.ajax({
                url:`{{url('/admin/enquiries/get_dynamic_data?service_id=${service_id}')}}`
            }).then(response=>{
                console.log(response);
                $("#dynamic_data").html(response);
            }).fail(error=>console.log('error',error));
        });

        $("#tenure_range").ionRangeSlider({
            skin: "big",
            grid: true,
            min: 0,
            max: 100,
            from: 21,
            max_postfix: "+",
            prefix: "Tenure: ",
            postfix: " years"
        });

        $('#datatable').DataTable();

    </script>


@endsection



