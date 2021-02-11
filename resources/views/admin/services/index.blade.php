@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mt-3">
                <div class="card-body">
                    <div class="card-title">
                        Services List
                        <button style="float: right; font-weight: 900;" class="btn btn-primary  mb-2" type="button"  data-toggle="modal" data-target="#createServiceModal">
                            Create Service Staff
                        </button>
                    </div>
                    <div class="table-responsive">

                <table class="table table-bordered table-striped" id="datatable">
                    <thead>
                        <tr>
                            <th>Service Type</th>
                            <th>Banks</th>
                            <th>Tenure</th>
                            <th>Status</th>
                            <th>Fields</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($services as $service)
                        <tr>
                            <td>{{$service['data']['service_type']}}</td>
                            <td><button type="button" class="btn btn-info viewBanks" data-values="{{$service['data']['banks']}}"><i class="fa fa-eye"> View </i></button></td>
                            <td>{{$service['data']['min_tenure']}} - {{$service['data']['max_tenure']}} Years</td>
                            <td id="updateMessage{{$service['data']['id']}}">{{$service['data']['status'] ?"Active":"Inactive"}}</td>
                            <td><button type="button" class="btn btn-info viewFields" data-values="{{$service['fields']}}" data-service_id="{{$service['data']['id']}}"><i class="fa fa-eye"> View </i></button></td>
                            <td>

                                <button type="button" class="btn btn-success btn-sm getEditServiceData" id="getEditServiceData" data-value="{{collect($service)}}" data-service_id="{{$service['data']['id']}}"><i class="fa fa-edit"> Edit</i></button>
                                <button type="button" class="btn btn-warning btn-sm " id="getUpdateId" data-id="{{$service['data']['id']}}"><i class="ti-loop"> Change Status</i></button>

                            </td>
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


<div class="modal fade show" id="createServiceModal" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="exampleModalLabel">Create New Service</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="needs-validation was-validated" action="{{route('services.store')}}" method="POST">
                {{ csrf_field() }}
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom01">Service Type</label>
                        <input type="text" class="form-control" id="validationCustom01" placeholder="Service Type" name="service_type" required="">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter service type.</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom01">Add Banks</label>
                        <select class="form-control select2" name="banks_array[]" multiple required="">
                            @foreach($banks as $bank)
                            <option value="{{$bank->id}}">{{$bank->name}}</option>
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
                <button class="btn btn-gradient-primary" type="submit">Save Service</button>
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
            <form class="needs-validation was-validated" action="{{url('/admin/save_service_form_fields')}}" method="POST">
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


<div class="modal" id="EditServiceModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Service Edit</h4>
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
                    <strong>Success!</strong> Service was updated successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="EditServiceModalBody">
                    
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Change Status Service Modal -->
<div class="modal" id="StatusServiceModal">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <!-- Modal body -->
            <div class="modal-body">
                <h4>Service Status Changed Successfully.</h4>
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
        var banks = {!! json_encode($banks) !!};

        $("#tenure_range").ionRangeSlider({
            skin: "big",
            type: "double",
            grid: true,
            min: 0,
            max: 100,
            from: 25,
            to: 50,
            decorate_both: true,
            onStart: function (data) {
                $("#tenure_range").val(`${data.from};${data.to}`);

            },
            onFinish: function (data) {
                $("#tenure_range").val(`${data.from};${data.to}`);
            }
        });

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
            var service_id = $(this).data("service_id");
            var html = `<input type="hidden" name="service_id" value="${service_id}">`;
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


        $(".getEditServiceData").on("click",function(){
            var service = $(this).data("value");
            var service_id = $(this).data("service_id");
            var banks_id = service.data.banks.map(function(bank){
                return bank.id;
            })
            console.log('data',banks_id);
            var html = `<form class="needs-validation was-validated" action="{{url('admin/services/update/${service_id}')}}" method="POST">
                @method('PUT')
                @csrf
                <div class="form-row">
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom01">Service Type</label>
                        <input type="text" class="form-control" id="validationCustom01" placeholder="Service Type" name="service_type" value="${service.data.service_type}" required="">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter service type.</div>
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
                        <input type="text" class="js-range-slider" name="tenure_range" required="" id="edit_tenure_range" from="${service.data.min_tenure}" to="${service.data.max_tenure}" />
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter tenure range.</div>
                    </div>
                    </div>
                <button class="btn btn-gradient-primary" type="submit">Update Service</button>
                </form>`;
            
            console.log('modal',html);
            $("#EditServiceModal .modal-body #EditServiceModalBody").html(html);
            $(".select2").select2();

            $("#edit_tenure_range").ionRangeSlider({
                skin: "big",
                type: "double",
                grid: true,
                min: 0,
                max: 100,
                from: service.data.min_tenure,
                to: service.data.max_tenure,
                decorate_both: true,
                onStart: function (data) {
                    $("#edit_tenure_range").val(`${data.from};${data.to}`);

                },
                onFinish: function (data) {
                    $("#edit_tenure_range").val(`${data.from};${data.to}`);
                }
            });
            $("#EditServiceModal").modal("show");
        });

        //delete service
        // var deleteID;
        // $('body').on('click', '#getDeleteId', function(){
        //     deleteID = $(this).data('id');
        // })
        // $('#SubmitDeleteServiceForm').click(function(e) {
        //     e.preventDefault();
        //     var id = deleteID;
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //     $.ajax({
        //         url: "/admin/services/"+id,
        //         method: 'DELETE',
        //         data:{"_token": "{{ csrf_token() }}"},
        //         success: function(result) {
        //             console.log(result);
        //             $('#DeleteServiceModal').modal('hide');
        //             //window.location.reload();
        //         }
        //     });
        // });


        $(document).on("click","#getUpdateId",function(){
                id = $(this).data('id');
                
                $.ajax({
                    method:'POST',
                    url:`/admin/services/change-status`,
                    data:{id,"_token":"{{csrf_token()}}"}
                }).then(response=>{
                  if(response == '1'){
                    $('#updateMessage'+id).text('Active');
                    $('#StatusServiceModal').modal('show');
                    setInterval(function(){ 
                            $('#StatusServiceModal').modal('hide');
                    }, 4000);
                  }
                  if(response == '0'){
                    $('#updateMessage'+id).text('Not Active');
                    $('#StatusServiceModal').modal('show');
                    setInterval(function(){ 
                            $('#StatusServiceModal').modal('hide');
                    }, 4000);
                  }
                }).fail(error=>{
                    console.log('error',error);
                });
            });


    </script>


@endsection
