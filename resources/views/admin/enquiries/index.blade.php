

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
                        Enquiries List
                        <button style="font-weight: 900; float: right;" class="btn btn-primary  mb-2" type="button"  data-toggle="modal" data-target="#createEnquiryModal">
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
                            <th>Tenure</th>
                            <th>Status</th>
                            <th>Activity</th>
                            <th>Existing Loans</th>
                            <th>Applied Bank</th>
                            <th>Assigned Bank</th>
                            <th>Client Details</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enquiries as $e)
                        <tr>
                            <td>
                                <i class="fa fa-edit btn btn btn-outline-success getEditEnquiryData" id="getEditEnquiryData" data-value="{{collect($e)}}" data-enquiry_id="{{$e->id}}"></i>

                            </td>
                            <td>{{$e->id}}</td>
                            <td>{{$e->user->first_name}} {{$e->user->last_name}}</td>
                            <td>{{$e->service->service_type}}</td>
                            <td>{{$e->relationship_manager->name}}</td>
                            <td>{{$e->loan_amount}}</td>
                            <td>{{$e->eligible_loan_amount}}</td>
                            <td>{{$e->tenure}}</td>
                            <td>
                                <a class="change_enquiry_status text-primary" data-enquiry_id='{{$e->id}}' data-enquiry_status="{{$e->status}}" data-activities="{{$e->enquiry_status}}">
                                    {{$e->status_name}}
                                </a>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-secondary btn-round  viewActivities" data-values="{{$e->enquiry_activiy}}" data-enquiry_id="{{$e->id}}">View </button>
                            </td>


                            <td>
                                <button type="button" class="btn btn-outline-secondary btn-round  existingLoan" data-values="{{$e->existing_loan}}" data-enquiry_id="{{$e->id}}">View </button>
                            </td>

                            <td>
                                @if(isset($e->bank_id))
                                    {{$e->bank->name}}
                                @endif
                                @if(!isset($e->bank_id))
                                    Not Required
                                @endif
                            </td>

                            <td>
                                @if(isset($e->bank_id))
                                <a class="asign_propose_bank text-primary" data-enquiry_id='{{$e->id}}' data-bank_id = '{{$e->propose_bank_id}}' data-values='{{$e->service->banks}}'>{{$e->propose_bank->name}}</a>
                                @endif
                                @if(!isset($e->bank_id))
                                    Not Required
                                @endif
                            </td>



                            <td><button type="button" class="btn btn-outline-dark btn-round viewdetails" data-values="{{$e}}" data-enquiry_id="{{$e->id}}">More</button></td>
                            <td>{{$e->created_at->diffForHumans()}}</td>

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

<div class="modal fade show" id="activitiesModal" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="exampleModalLabel">Activities</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body ">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-3 text-center">Activities</h4>
                    <div class="activitiesList activity"></div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">

                    <div class="slimscroll activity-scroll">
                        <h4 class="header-title mt-0 mb-3">Create Activities</h4>
                        <form class="needs-validation was-validated" action="{{url('/admin/save_enquiry_activity')}}" method="POST">
                            {{ csrf_field() }}
                            <div id="form-content" class="activitiesForm">

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


<div class="modal fade show" id="existingloanModal" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="exampleModalLabel">Existing Loans</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-3">Existing Loans</h4>
                    <div class="activity" id="existingLoanList1"></div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">

                    <div class="slimscroll activity-scroll">

                        <h4 class="header-title mt-0 mb-3">Add Existing Loan Details</h4>
                        <form class="needs-validation was-validated" action="{{url('/admin/save_existing_loan')}}" method="POST">
                            {{ csrf_field() }}
                            <div id="form-content" class="existingLoanForm1">

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




<div class="modal fade show" id="changeEnquiryStatus" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="exampleModalLabel">Change Status</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body ">
            <div class="card">
                <div class="card-body">
                    <form class="needs-validation was-validated" action="{{url('/admin/change_enquiry_status')}}" method="POST">
                            {{ csrf_field() }}
                            <div id="form-content" class="enquiryStatus">

                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="text-center">Status Tracking</h4>
                    <div class="activitiesList activity">

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


<div class="modal fade show" id="asignProposeBank" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="exampleModalLabel">Propose Bank</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body ">
            <div class="card">
                <div class="card-body">
                    <form class="needs-validation was-validated" action="{{url('/admin/asign_propose_bank')}}" method="POST">
                            {{ csrf_field() }}
                            <div id="form-content" class="proposeBank">

                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
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
                                    <option selected value="">Select</option>
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
                                    <option selected value="">Select</option>
                                    @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->first_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Choose Location</label>
                            <div class="col-lg-9">

                                <select name="location_id" type="text" class="form-control select2" required>
                                    <option selected value="">Select</option>
                                    @foreach($locations as $location)
                                    <option value="{{$location->id}}">{{$location->name}}</option>
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
                            <div class="col-lg-9">

                                <select name="income_from" type="text" class="form-control select2">
                                    <option selected value="">Select</option>

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
                                <input name="salary_month" type="text" class="form-control staffRquiredField js-range-slider-monthly-income" placeholder="Monthly Income">
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
                                    <option selected value="">Select</option>
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


                <div class="p-3">
                    <label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input">
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">Please Click on Submit to Create Enquiry</span>
                    </label>

                    <div class="p-3" id="enquiryFormError"></div>

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



<div class="modal fade show" id="EditEnquiryModal" tabindex="-1" role="dialog" >

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Enquiry Edit</h4>
                <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div id="EditEnquiryModalBody">

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
        var staffs = {!! json_encode($staffs) !!};
        var users = {!! json_encode($users) !!};
        var locations = {!! json_encode($locations) !!};
        var statuses = {!! json_encode($statuses) !!};


        $(".js-range-slider-monthly-income").ionRangeSlider({
            skin: "big",
            grid: true,
            min: 0,
            max: 1000000,
            from: 1000
        });

        $(document).on("change","#service_id",function(){
            const service_id = $(this).val();
            $.ajax({
                url:`{{url('/admin/enquiries/get_dynamic_data?service_id=${service_id}')}}`
            }).then(response=>{
                $("#dynamic_data").html(response);
                $(".js-range-slider").ionRangeSlider({
                    skin: "big",
                    grid: true,
                    min: 0,
                    max: 100000000,
                    from: 10000
                });
                $(".js-range-slider-tenure").ionRangeSlider({
                    skin: "big",
                    grid: true,
                    min: 0,
                    max: 100,
                    from: 5
                });
                $(".select2").select2();
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




        $(".viewActivities").on("click",function(){
            var activities = $(this).data("values");
            var enquiry_id = $(this).data("enquiry_id");

            var htmlList = '';
            var htmlForm = '';

            activities.forEach(function(e){
                htmlList += `<div class="activity-info">
                                <div class="icon-info-activity">
                                    <i class="mdi mdi-checkbox-marked-circle-outline bg-soft-success"></i>
                                </div>
                                <div class="activity-info-text">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="m-0 w-75">${e.note}</h6>
                                        <span class="text-muted d-block">${e.created_at}</span>

                                    </div>
                                    <p class="text-muted mt-1"></p>
                                </div>
                            </div>`;
            });

            htmlForm += `<div class="col-md-12 mb-3">
                        <label for="validationCustom01">Activity</label>
                        <textarea name="note" class="form-control" required row="5"></textarea>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter amount.</div>
                    </div>
                    <input type="hidden" value="${enquiry_id}" name="enquiry_id">
                    `;

            $("#activitiesModal .activitiesList").html(htmlList);
            $("#activitiesModal .activitiesForm").html(htmlForm);

            $("#activitiesModal").modal("show");
        });


        $(".existingLoan").on("click",function(){
            var loans = $(this).data("values");
            var enquiry_id = $(this).data("enquiry_id");

            var htmlList = '';
            var htmlForm = '';

            loans.forEach(function(e){
                htmlList += `<div class="activity-info">
                                <div class="icon-info-activity">
                                    <i class="mdi mdi-checkbox-marked-circle-outline bg-soft-success"></i>
                                </div>

                                <div class="activity-info-text">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="m-0 w-75">${e.product}-${e.loan_amount} </h6>
                                        <span class="text-muted d-block">${e.created_at}</span>

                                    </div>
                                    <p class="text-muted mt-1">Tenure:${e.tenure}</p>
                                    <p class="text-muted mt-1">BANK:${e.bank} - EMI:${e.emi}</p>
                                </div>
                            </div>`;
            });
                htmlForm += `</select>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please select service.</div>
                    </div>
                    <input type="hidden" value="${enquiry_id}" name="enquiry_id">
                    <div id="dynamic_data_bank"></div>
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom01">Product Type</label>
                        <input name="product" type="text" placeholder="Product Type" class="form-control" required >
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter Product Type.</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom01">Bank</label>
                        <input name="bank" type="text" placeholder="Bank" class="form-control" required >
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter Bank.</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom01">Loan Amount</label>
                        <input type="text" class="js-range-slider" name="loan_amount" required="" id="loan_amount_range1"/>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter loan amount.</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom01">EMI</label>
                        <input name="emi" type="text" placeholder="EMI" class="form-control" required >
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter amount.</div>
                    </div>
                    <div class="col-md-12 mb-3">
                    <label for="validationCustom01">Tenure</label>
                    <input type="text" class="js-range-slider" name="tenure" required="" id="tenure_range1"/>
                    <div class="valid-feedback">Looks good!</div>
                    <div class="invalid-feedback">Please enter tenure range.</div>
                    </div>
                    `;

            $("#existingLoanList1").html(htmlList);
            $(".existingLoanForm1").html(htmlForm);

            $("#existingloanModal").modal("show");
            $("#tenure_range1").ionRangeSlider({
                skin: "big",
                grid: true,
                min: 0,
                max: 100,
                from: 5,
                prefix: "Tenure: ",
                postfix: " years"
            });

            $("#loan_amount_range1").ionRangeSlider({
                skin: "big",
                grid: true,
                min: 0,
                max: 100000000,
                from: 10000
            });

        });


        $(".eligibleLoanTrigger").on("click",function(){
            var amount = $(this).data("values");
            var max = $(this).data("maxamm");
            var enquiry_id = $(this).data("enquiry_id");

            var htmlList = '';
            var htmlForm = '';


                htmlList += `<div class="activity-info">

                                <div class="activity-info-text">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="m-0 w-75">Eligible Loan Amount</h6>

                                    </div>
                                    <p class="text-muted mt-1">${amount}</p>
                                </div>
                            </div>`;


            htmlForm += `<div class="form-group row">
                                    <label class="col-lg-3 col-form-label">Amount</label>
                                    <div class="col-lg-9">
                                        <input name="eligible_loan_amount" type="number" class="form-control staffRquiredField" max="${max}" placeholder="Loan Amount" required>
                                    </div>
                                </div>
                    <input type="hidden" value="${enquiry_id}" name="enquiry_id">
                    `;

            $("#loanModal #eligibleLoanAmount").html(htmlList);
            $("#loanModal .eligibleLoanHtml").html(htmlForm);

            $("#loanModal").modal("show");
        });


        $(document).on("change",".serviceForExistingLoan",function(){
            const service_id = $(this).val();
            $.ajax({
                url:`{{url('/admin/enquiries/get_loan_bank_data?service_id=${service_id}')}}`
            }).then(response=>{
                html = '';
                html+=`<div class="col-md-12 mb-3">
                        <label for="validationCustom01">Bank</label>
                        <select class="form-control select2" name="bank" id="validationCustom01" required="">
                            <option selectd default></option>`

                         response.forEach(function(d){
                            html+=`<option value="${d.name}">${d.name}</option>`
                        });

                    html+=`</select>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please select service.</div>
                    </div>`;

                    ('#get_service_tenure_data').html(html);

            }).fail(error=>console.log('error',error));
        });


        $(".viewdetails").on("click",function(){
        var d = $(this).data("values");

        var htmlList =`<div class="cart-wrap ftco-animate">
                <div class="cart-total mb-3">
                  <h5>Persional Details</h5>
                  <hr>
                  <p class="d-flex total-price">
                    <span>Name</span>
                    <span id="final_price">${d.user.first_name} ${d.user.last_name}</span>
                  </p>
                  <p class="d-flex total-price">
                    <span>Mobile Number</span>
                    <span id="final_price">${d.user.mobile_number}</span>
                  </p>
                  <p class="d-flex total-price">
                    <span>Email</span>
                    <span id="final_price">${d.user.email}</span>
                  </p>
                  <p class="d-flex total-price">
                    <span>Address</span>
                    <span id="final_price">${d.user.address}</span>
                  </p>
                  <p class="d-flex total-price">
                    <span>Location</span>
                    <span id="final_price">${d.location.name}</span>
                  </p>
                  <p class="d-flex total-price">
                    <span>Salary per month</span>
                    <span id="final_price">${d.salary_month}</span>
                  </p>
                  <p class="d-flex total-price">
                    <span>Company Name</span>
                    <span id="final_price">${d.company_business_name}</span>
                  </p>
                  <p class="d-flex total-price">
                    <span>Employment Type</span>
                    <span id="final_price">${d.income_from}</span>
                  </p>

                </div>

              </div>`;

        $("#detailsModal .detailsData").html(htmlList);

        $("#detailsModal").modal("show");
    });



    $(".change_enquiry_status").on("click",function(){

        var enquiry_id = $(this).data("enquiry_id");
        var enquiry_status = $(this).data("enquiry_status");
        const activities = $(this).data("activities");

        var html = `<div class="col-md-12 mb-3">
                        <label for="validationCustom01">Update Status</label>
                        <select class="form-control select2" name="status" id="validationCustom01" required="">`;

                            Object.entries(statuses).forEach(([key, value]) => {
                                html += `<option value="${value}" ${value == enquiry_status?"selected":""}>${key}</option>`;
                            });

                html += `</select>
                        <input type="hidden" value="${enquiry_id}" name="enquiry_id">

                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please select status.</div>
                    </div>`;

        $("#changeEnquiryStatus .enquiryStatus").html(html);

        let activity = "";
        activities.forEach(function(e){
            activity += `<div class="activity-info">
                            <div class="icon-info-activity">
                                <i class="mdi mdi-checkbox-marked-circle-outline bg-soft-success"></i>
                            </div>
                            <div class="activity-info-text">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 w-75">${e.status_name}</h6>
                                    <span class="text-muted d-block">${e.created_at}</span>

                                </div>
                                <p class="text-muted mt-1"></p>
                            </div>
                        </div>`;
        });
        $("#changeEnquiryStatus .activitiesList").html(activity);

        $("#changeEnquiryStatus").modal("show");
        $(".select2").select2();
    });


    $(".asign_propose_bank").on("click",function(){

        var enquiry_id = $(this).data("enquiry_id");
        var banks = $(this).data("values");
        const bank_id = $(this).data("bank_id");

        var html = `<div class="col-md-12 mb-3">
                        <label for="validationCustom01">Propose Bank</label>
                        <select class="form-control select2" name="propose_bank_id" id="validationCustom01" required="">`;

                         banks.forEach(function(d){
                            html += `<option value="${d.id}" ${d.id == bank_id?"selected":""}>${d.name}</option>`;
                        });



                html += `</select>
                        <input type="hidden" value="${enquiry_id}" name="enquiry_id">

                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please select bank.</div>
                    </div>`;

        $("#asignProposeBank .proposeBank").html(html);

        $("#asignProposeBank").modal("show");
        $(".select2").select2();
    });




    $(".getEditEnquiryData").on("click",function(){
            var enquiry = $(this).data("value");
            var enquiry_id = $(this).data("enquiry_id");

            var html = `<form class="needs-validation was-validated" action="{{url('admin/enquiries/update/${enquiry_id}')}}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Choose Service</label>
                            <div class="col-lg-9">

                                <select name="service_id" id="edit_service_id" class="form-control select2" required data-enquiry_id="${enquiry_id}">

                                `;


                         services.forEach(function(d){
                            html += `<option value="${d.id}" ${enquiry.service_id==d.id?'selected':''}>${d.service_type}</option>`;
                        });



                html += `
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtEmailAddressBilling" class="col-lg-3 col-form-label">Loan Amount</label>
                            <div class="col-lg-9">
                                <input name="loan_amount" type="number" class="form-control staffRquiredField" placeholder="Loan Amount" value="${enquiry.loan_amount}" required>
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Choose User</label>
                            <div class="col-lg-9">

                                <select name="user_id" type="text" class="form-control select2" required>`;


                         users.forEach(function(d){
                            html += `<option value="${d.id}" ${enquiry.user_id==d.id?'selected':''}>${d.first_name} ${d.last_name}</option>`;
                        });



                html += `
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Choose Location</label>
                            <div class="col-lg-9">

                                <select name="location_id" type="text" class="form-control select2" required>`;


                         locations.forEach(function(d){
                            html += `<option value="${d.id}" ${enquiry.location_id==d.id?'selected':''}>${d.name}</option>`;
                        });



                html += `

                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtCompanyBilling" class="col-lg-3 col-form-label">Employment Type</label>
                            <div class="col-lg-9">

                                <select name="income_from" type="text" class="form-control select2">

                                    <option ${enquiry.income_from=='Salary'?'Selected':''} value="Salary">Self Employed</option>
                                    <option ${enquiry.income_from=='Business'?'Selected':''} value="Business">Business</option>

                                </select>
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtEmailAddressBilling" class="col-lg-3 col-form-label">Monthly Income</label>
                            <div class="col-lg-9">
                                <input name="salary_month" type="number" class="form-control staffRquiredField" placeholder="Monthly Income" value="${enquiry.salary_month}">
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                </div><!--end row-->


                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtFaxBilling" class="col-lg-3 col-form-label">Relationship Manager</label>
                            <div class="col-lg-9">

                                <select name="relationship_manager_id" class="form-control select2" required>`;


                         staffs.forEach(function(d){
                            html += `<option value="${d.id}" ${enquiry.business_relationship_id==d.id?'selected':''}>${d.name}</option>`;
                        });


                html += `

                                </select>
                            </div>
                        </div><!--end form-group-->
                    </div><!--end col-->
                    <!--end col-->
                </div><!--end row-->

                <div class="row" id="edit_dynamic_data">

                </div>


                <div class="p-3">`;


                if(enquiry.aadhar.length>0){
                    var aadhar = enquiry.aadhar.split(',');

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
                                    <input type="" class="get_product_id" value="${enquiry.id}" hidden>
                                    <button class="btn btn-danger deleteImage" id="${i}" type="button" data-value="aadhar">Remove</button>
                                  </div>
                                </div>
                            </div>
                        </div>`;
                    })


                  }

                  if(enquiry.pan.length>0){
                    var pan = enquiry.pan.split(',');

                    pan.map((i, e) => {

                    html+=`
                    <div class="row my-3">
                        <div class=" col-md-5">PAN Document-${e+1}</div>
                            <div class=" col-md-7">
                                <div class="d-flex flex-row">
                                  <div class="col-md-8">
                                    <img src="{{ asset('uploads/${i}') }}" class="img-fluid" width="70px">
                                  </div>
                                  <div class="col-md-4">
                                    <input type="" class="get_product_id" value="${enquiry.id}" hidden>
                                    <button class="btn btn-danger deleteImage" id="${i}" type="button" data-value="pan">Remove</button>
                                  </div>
                                </div>
                            </div>
                        </div>`;
                    })


                  }



                  if(enquiry.address_proof.length>0){
                    var address_proof = enquiry.address_proof.split(',');

                    address_proof.map((i, e) => {

                    html+=`
                    <div class="row my-3">
                        <div class=" col-md-5">Address Proof Document-${e+1}</div>
                            <div class=" col-md-7">
                                <div class="d-flex flex-row">
                                  <div class="col-md-8">
                                    <img src="{{ asset('uploads/${i}') }}" class="img-fluid" width="70px">
                                  </div>
                                  <div class="col-md-4">
                                    <input type="" class="get_product_id" value="${enquiry.id}" hidden>
                                    <button class="btn btn-danger deleteImage" id="${i}" type="button" data-value="address_proof">Remove</button>
                                  </div>
                                </div>
                            </div>
                        </div>`;
                    })


                  }

                  if(enquiry.payslip.length>0){
                    var payslip = enquiry.payslip.split(',');

                    payslip.map((i, e) => {

                    html+=`
                    <div class="row my-3">
                        <div class=" col-md-5">Payslip Document-${e+1}</div>
                            <div class=" col-md-7">
                                <div class="d-flex flex-row">
                                  <div class="col-md-8">
                                    <img src="{{ asset('uploads/${i}') }}" class="img-fluid" width="70px">
                                  </div>
                                  <div class="col-md-4">
                                    <input type="" class="get_product_id" value="${enquiry.id}" hidden>
                                    <button class="btn btn-danger deleteImage" id="${i}" type="button" data-value="payslip">Remove</button>
                                  </div>
                                </div>
                            </div>
                        </div>`;
                    })


                  }

                  if(enquiry.return_statement.length>0){
                    var return_statement = enquiry.return_statement.split(',');

                    return_statement.map((i, e) => {

                    html+=`
                    <div class="row my-3">
                        <div class=" col-md-5">Return Statement Document-${e+1}</div>
                            <div class=" col-md-7">
                                <div class="d-flex flex-row">
                                  <div class="col-md-8">
                                    <img src="{{ asset('uploads/${i}') }}" class="img-fluid" width="70px">
                                  </div>
                                  <div class="col-md-4">
                                    <input type="" class="get_product_id" value="${enquiry.id}" hidden>
                                    <button class="btn btn-danger deleteImage" id="${i}" type="button" data-value="return_statement">Remove</button>
                                  </div>
                                </div>
                            </div>
                        </div>`;
                    })


                  }

                  if(enquiry.bank_statement.length>0){
                    var bank_statement = enquiry.bank_statement.split(',');

                    bank_statement.map((i, e) => {

                    html+=`
                    <div class="row my-3">
                        <div class=" col-md-5">Bank Statement Document-${e+1}</div>
                            <div class=" col-md-7">
                                <div class="d-flex flex-row">
                                  <div class="col-md-8">
                                    <img src="{{ asset('uploads/${i}') }}" class="img-fluid" width="70px">
                                  </div>
                                  <div class="col-md-4">
                                    <input type="" class="get_product_id" value="${enquiry.id}" hidden>
                                    <button class="btn btn-danger deleteImage" id="${i}" type="button" data-value="bank_statement">Remove</button>
                                  </div>
                                </div>
                            </div>
                        </div>`;
                    })


                  }

                  if(enquiry.others.length>0){
                    var others = enquiry.others.split(',');

                    others.map((i, e) => {

                    html+=`
                    <div class="row my-3">
                        <div class=" col-md-5">Others Document-${e+1}</div>
                            <div class=" col-md-7">
                                <div class="d-flex flex-row">
                                  <div class="col-md-8">
                                    <img src="{{ asset('uploads/${i}') }}" class="img-fluid" width="70px">
                                  </div>
                                  <div class="col-md-4">
                                    <input type="" class="get_product_id" value="${enquiry.id}" hidden>
                                    <button class="btn btn-danger deleteImage" id="${i}" type="button" data-value="others">Remove</button>
                                  </div>
                                </div>
                            </div>
                        </div>`;
                    })


                  }



                   html+=`<label class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input">
                        <span class="custom-control-indicator"></span>
                        <span class="custom-control-description">Please Click on Update to Create Enquiry</span>
                    </label>

                    <div class="p-3" id="EnquiryFormError"></div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

                </form>`;


            $("#EditEnquiryModal .modal-body #EditEnquiryModalBody").html(html);

            $("#edit_service_id").trigger("change");
            $("#EditEnquiryModal").modal("show");
            $(".select2").select2();
        });


        $(document).on("change","#edit_service_id",function(){
            const service_id = $(this).val();
            const enquiry_id = $(this).data("enquiry_id");
            const url = `admin/enquiries/get_edit_dynamic_data?service_id=${service_id}&enquiry_id=${enquiry_id}`;
            $.ajax({
                url:`{{url('${url}')}}`
            }).then(response=>{
                $("#edit_dynamic_data").html(response);
                $(".select2").select2();
            }).fail(error=>console.log('error',error));
        });


        $(document).on("click",".deleteImage",function(){
            const el = this;
            const enquiry_id = $('.get_product_id').val();
            const image_name=this.id;
            const doc_type = $(this).data("value");
            $.ajax({
                method:'POST',
                url:`/admin/enquiries/getDeleteSelectedImages`,
                data:{image_name,enquiry_id,doc_type,"_token":"{{csrf_token()}}"},
                encode  : true
            }).then(response=>{
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



