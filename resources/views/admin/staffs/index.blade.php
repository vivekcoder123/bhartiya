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
                        <button style="float: right; font-weight: 900;" class="btn btn-primary  mb-2" type="button"  data-toggle="modal" data-target="#CreateStaffModal">
                            Create New Staff
                        </button>
                    </div>
                    <div class="table-responsive">

                <table class="table table-bordered table-striped" id="datatable">
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Employee Id</th>
                            <th>Name</th>
                            <th>Report To</th>
                            <th>Designation</th>
                            <th>Permissions</th>
                            <th>Incentives</th>
                            <th>Business Targets</th>
                            <th>Details</th>
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staffs as $staff)
                        <tr>
                            <td>
                                <button type="button" class="btn btn-success btn-sm getEditStaffData" id="getEditStaffData" data-value="{{collect($staff)}}" data-staff_id="{{$staff->id}}"><i class="fa fa-edit"> Edit</i></button>
                                <button type="button" data-id="{{$staff->id}}'" data-toggle="modal" data-target="#DeleteStaffModal" class="btn btn-danger btn-sm" id="getDeleteId"><i class="ti-trash"> Delete</i></button>

                            </td>
                            <td>{{$staff->employee_id}}</td>
                            <td>{{$staff->name}}</td>
                            <td>{{$staff->reportTo->name}}</td>
                            <td>{{$staff->designation->name}}</td>
                            <td>

                                <button type="button" class="btn btn-outline-purple btn-round dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Permissions <i class="mdi mdi-chevron-down"></i></button>

                                
                                <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 39px, 0px);">
                                        
                                        @foreach(explode(',',$staff->permissions) as $p)  
                                            <a class="dropdown-item" href="#">{{$p}}</a>
                                         @endforeach
                                        
                                    </div>
                            
                            </td>

                            <td><button type="button" class="btn btn-outline-secondary btn-round  viewIncentives" data-values="{{$staff->incentives}}" data-staff_id="{{$staff->id}}"><i class="fa fa-eye"></i> View </button></td>
                                
                            <td><button type="button" class="btn btn-outline-secondary btn-round  viewtargets" data-values="{{$staff->targets}}" data-staff_id="{{$staff->id}}"><i class="fa fa-eye"></i> View</button></td>

                            <td><button type="button" class="btn btn-outline-dark btn-round viewdetails" data-values="{{$staff}}" data-staff_id="{{$staff->id}}">More</button></td>
                
                            
                            
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

<div class="modal fade show" id="incentivesModal" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="exampleModalLabel">Incentives</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body ">
            <div class="card">                                       
                <div class="card-body"> 
                    <h4 class="header-title mt-0 mb-3">Incentives</h4>

                    <div class="slimscroll activity-scroll">
                            
                                
                        <div class="incentivesList activity" style="max-height: 250px; overflow: auto;"></div>
                        <h4 class="header-title mt-0 mb-3">Create Incentives</h4>
                        <form class="needs-validation was-validated" action="{{url('/admin/save_staff_incentive')}}" method="POST">
                            {{ csrf_field() }}
                            <div id="form-content" class="incentivesForm">

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
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="exampleModalLabel">Create New Staff</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="needs-validation was-validated" action="{{route('staffs.store')}}" method="POST">
                {{ csrf_field() }}
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom01">Staff Type</label>
                        <input type="text" class="form-control" id="validationCustom01" placeholder="Staff Type" name="Staff_type" required="">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter Staff type.</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom01">Add Banks</label>
                        <select class="form-control select2" name="banks_array[]" multiple required="">
                            @foreach($services as $service)
                            <option value="{{$service->id}}">{{$service->name}}</option>
                            @endforeach
                        </select>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please select atleast one bank.</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom01">Tenure</label>
                        <input type="text" class="js-range-slider" name="tenure_range" required="" id="tenure_range"/>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter tenure range.</div>
                    </div>
                    </div>
                <button class="btn btn-gradient-primary" type="submit">Save Staff</button>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Staff Edit</h4>
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

<!-- Change Status Staff Modal -->
<div class="modal" id="StatusStaffModal">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <!-- Modal body -->
            <div class="modal-body">
                <h4>Staff Status Changed Successfully.</h4>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


@endsection

@section('js')

    <script>
       
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


        $(".getEditStaffData").on("click",function(){
            var Staff = $(this).data("value");
            var Staff_id = $(this).data("Staff_id");
            var banks_id = Staff.data.banks.map(function(bank){
                return bank.id;
            })
            console.log('data',banks_id);
            var html = `<form class="needs-validation was-validated" action="{{url('admin/Staffs/update/${Staff_id}')}}" method="POST">
                @method('PUT')
                @csrf
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom01">Staff Type</label>
                        <input type="text" class="form-control" id="validationCustom01" placeholder="Staff Type" name="Staff_type" value="${Staff.data.Staff_type}" required="">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter Staff type.</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom01">Add Banks</label>
                        <select class="form-control select2" name="banks_array[]" multiple required="">`;


                         banks.forEach(function(d){
                            html += `<option value="${d.id}" ${banks_id.includes(d.id)?'selected':''}>${d.name}</option>`;
                        });



                html += `</select>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please select atleast one bank.</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom01">Tenure</label>
                        <input type="text" class="js-range-slider" name="tenure_range" required="" id="edit_tenure_range" from="${Staff.data.min_tenure}" to="${Staff.data.max_tenure}" />
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter tenure range.</div>
                    </div>
                    </div>
                <button class="btn btn-gradient-primary" type="submit">Update Staff</button>
                </form>`;
            
            console.log('modal',html);
            $("#EditStaffModal .modal-body #EditStaffModalBody").html(html);
            $(".select2").select2();

            $("#edit_tenure_range").ionRangeSlider({
                skin: "big",
                type: "double",
                grid: true,
                min: 0,
                max: 100,
                from: Staff.data.min_tenure,
                to: Staff.data.max_tenure,
                decorate_both: true,
                onStart: function (data) {
                    $("#edit_tenure_range").val(`${data.from};${data.to}`);

                },
                onFinish: function (data) {
                    $("#edit_tenure_range").val(`${data.from};${data.to}`);
                }
            });
            $("#EditStaffModal").modal("show");
        });

        //delete Staff
        // var deleteID;
        // $('body').on('click', '#getDeleteId', function(){
        //     deleteID = $(this).data('id');
        // })
        // $('#SubmitDeleteStaffForm').click(function(e) {
        //     e.preventDefault();
        //     var id = deleteID;
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //     $.ajax({
        //         url: "/admin/Staffs/"+id,
        //         method: 'DELETE',
        //         data:{"_token": "{{ csrf_token() }}"},
        //         success: function(result) {
        //             console.log(result);
        //             $('#DeleteStaffModal').modal('hide');
        //             //window.location.reload();
        //         }
        //     });
        // });


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
                                        
                                    </div>
                                    <p class="text-muted mt-3">${incentive.remarks} 
                                    </p>
                                </div>
                            </div>`;
            });

            htmlForm += `<div class="col-md-12 mb-3">
                        <label for="validationCustom01">Incentive Amount</label>
                        <input type="text" class="form-control" id="validationCustom01" placeholder="Amount" name="incentive" type="number" required="">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter amount.</div>
                    </div>
                    <input type="hidden" value="${staff_id}" name="staff_id" >
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom02">Remarks</label>
                        <input type="text" class="form-control" id="validationCustom02" type="text" placeholder="Remarks" name="remarks" >
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter remarks (optional).</div>
                    </div>`;

            $("#incentivesModal .incentivesList").html(htmlList);
            $("#incentivesModal .incentivesForm").html(htmlForm);
            
            $("#incentivesModal").modal("show");
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
                        <span>PAN No.</span>
                        <span id="final_price">${d.pan}</span>
                      </p>
                      <p class="d-flex total-price">
                        <span>Aadhar No.</span>
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




    </script>


@endsection
