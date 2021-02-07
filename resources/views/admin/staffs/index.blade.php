@extends('layouts.admin')

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
                            <th>Email</th>
                            <th>Mobile No.</th>
                            <th>Location</th>
                            <th>D.O.J.</th>
                            <th>Address</th>
                            <th>Current Address</th>
                            <th>Emergency Contact</th>
                            <th>Blook Group</th>
                            <th>Qualification</th>
                            <th>D.O.B.</th>
                            <th>PAN No.</th>
                            <th>Aadhar No.</th>
                            <th>Marital Status</th>
                            <th>Family Members</th>
                            <th>Anniversary</th>
                            
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
                            @foreach(explode(',',$staff->permissions) as $p)  
                                <button class="btn btn-secondary btn-sm" type="button">{{$p}}</button>
                             @endforeach
                            </td>

                            <td><button type="button" class="btn btn-info viewIncentives" data-values="{{$staff->incentives}}"><i class="fa fa-eye"> View & Update </i></button></td>
                                
                            <td><button type="button" class="btn btn-info viewtargets" data-values="{{$staff->targets}}"><i class="fa fa-eye"> View & Update </i></button></td>

                            <td>{{$staff->email}}</td>
                            <td>{{$staff->mobile_number}}</td>
                            <td>{{$staff->location->name}}</td>
                            <td>{{date("j M Y",strtotime($staff->doj))}}</td>
                            <td>{{$staff->address}}</td>
                            <td>{{$staff->current_address}}</td>
                            <td>{{$staff->emergency_contact}}</td>
                            <td>{{$staff->blood_group}}</td>
                            <td>{{$staff->qualification}}</td>
                            <td>{{date("j M Y",strtotime($staff->dob))}}</td>
                            <td>{{$staff->pan}}</td>
                            <td>{{$staff->aadhar}}</td>
                            <td>{{$staff->marital_status}}</td>
                            <td>{{$staff->family_members}}</td>
                            <td>{{date("j M Y",strtotime($staff->anniversary))}}</td>
                            
                            
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

<div class="modal fade show" id="banksModal" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="exampleModalLabel">Banks</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">

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


    </script>


@endsection
