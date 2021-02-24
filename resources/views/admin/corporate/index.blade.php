

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
                        Corporates List
                        <button style="font-weight: 900; float: right;" class="btn btn-primary  mb-2" type="button"  data-toggle="modal" data-target="#createCorporateModal">
                            Create New Corporate
                        </button>
                    </div>

                    <div class="table-responsive">

                <table class="table table-bordered table-striped" id="datatable">
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Products Head</th>
                            <th>Company Name</th>
                            <th>Status</th>
                            <th>Emplyee Strenght</th>
                            <th>Location</th>
                            <th>Contact Person Name</th>
                            <th>Phone</th>
                            <th>Designation</th>
                            <th>Note</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($corporates as $e)
                        <tr>
                            <td>
                                <i class="fa fa-edit btn btn btn-outline-success getEditCorporateData" id="getEditCorporateData" data-value="{{collect($e)}}" data-corporate_id="{{$e->id}}"></i>

                            </td>
                            <td>{{$e->product_head}}</td>
                            <td>{{$e->company_name}}</td>
                            <td>
                                <a class="change_corporate_status text-primary" data-corporate_id='{{$e->id}}' data-corporate_status="{{$e->status}}">

                                    @if($e->status == '0')
                                        IN PROCESS
                                    @endif
                                    @if($e->status == '1')
                                        ON BORDERED
                                    @endif
                                    @if($e->status == '2')
                                        NOT INTERESTED
                                    @endif

                                </a>
                            </td>
                            <td>{{$e->employee_strength}}</td>
                            <td>{{$e->location->name}}</td>
                            <td>{{$e->name}}</td>
                            <td>{{$e->mobile_number}}</td>
                            <td>{{$e->designation}}</td>
                            <td>{{$e->note}}</td>
                            
                        @endforeach
                    </tbody>
                </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>


<div class="modal fade show" id="changeCorporateStatus" tabindex="-1" role="dialog" >
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
                    <form class="needs-validation was-validated" action="{{url('/admin/change_corporate_status')}}" method="POST">
                            {{ csrf_field() }}
                            <div id="form-content" class="CorporateStatus">

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



<div class="modal fade show" id="createCorporateModal" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="exampleModalLabel">Create New Corporate</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <form  action="{{route('corporates.store')}}" method="POST" >
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Product Head</label>
                            <div class="col-lg-9">

                                <input type="text" class="form-control" name="product_head" required placeholder="Product Head">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Company Name</label>
                            <div class="col-lg-9">

                                <input type="text" class="form-control" name="company_name" required placeholder="Company Name">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Emplyee Strength</label>
                            <div class="col-lg-9">

                                <input type="number" class="form-control" name="employee_strength" required placeholder="Emplyee Strength">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Note</label>
                            <div class="col-lg-9">

                                <textarea name="note" class="form-control" required row="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h4>Contact Person</h4>
                    </div>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Name</label>
                            <div class="col-lg-9">

                                <input type="text" class="form-control" name="name" required placeholder="Name">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Phone</label>
                            <div class="col-lg-9">

                                <input type="number" class="form-control" name="mobile_number" required placeholder="Phone">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Designation</label>
                            <div class="col-lg-9">

                                <input type="text" class="form-control" name="designation" required placeholder="Designation">
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

                <div class="p-3">
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



<div class="modal fade show" id="EditCorporateModal" tabindex="-1" role="dialog" >

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Corporate Edit</h4>
                <button type="button" class="close modelClose" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div id="EditCorporateModalBody">

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

        var locations = {!! json_encode($locations) !!};

    $(".change_corporate_status").on("click",function(){

        var corporate_id = $(this).data("corporate_id");
        var corporate_status = $(this).data("corporate_status");
        
        var html = `<div class="col-md-12 mb-3">
                        <label for="validationCustom01">Update Status</label>
                        <select class="form-control select2" name="status" id="validationCustom01" required="">
                                <option value="0" ${corporate_status=='0'?"selected":""}>IN PROCESS</option>
                                <option value="1" ${corporate_status=='1'?"selected":""}>ON BORDERED</option>
                                <option value="2" ${corporate_status=='2'?"selected":""}>NOT INTERESTED</option>
                            </select>
                        <input type="hidden" value="${corporate_id}" name="corporate_id">

                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please select status.</div>
                    </div>`;

        $("#changeCorporateStatus .CorporateStatus").html(html);

        $("#changeCorporateStatus").modal("show");

        $(".select2").select2();
    });


    $(".getEditCorporateData").on("click",function(){
            var corporate = $(this).data("value");
            var corporate_id = $(this).data("corporate_id");

            var html = `<form class="needs-validation was-validated" action="{{url('admin/corporates/update/${corporate_id}')}}" method="POST">
                @method('PUT')
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Product Head</label>
                            <div class="col-lg-9">

                                <input type="text" class="form-control" name="product_head" value="${corporate.product_head}" required placeholder="Product Head">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Company Name</label>
                            <div class="col-lg-9">

                                <input type="text" class="form-control" name="company_name" value="${corporate.company_name}" required placeholder="Company Name">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Emplyee Strength</label>
                            <div class="col-lg-9">

                                <input type="number" class="form-control" name="employee_strength" required value="${corporate.employee_strength}" placeholder="Emplyee Strength">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Note</label>
                            <div class="col-lg-9">

                                <textarea name="note" class="form-control" required row="3">${corporate.note}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h4>Contact Person</h4>
                    </div>
                    <hr>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Name</label>
                            <div class="col-lg-9">

                                <input type="text" class="form-control" name="name" required placeholder="Name" value="${corporate.name}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Phone</label>
                            <div class="col-lg-9">

                                <input type="number" class="form-control" name="mobile_number" required placeholder="Phone" value="${corporate.mobile_number}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Designation</label>
                            <div class="col-lg-9">

                                <input type="text" class="form-control" name="designation" required placeholder="Designation" value="${corporate.designation}">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="txtLastNameBilling" class="col-lg-3 col-form-label">Choose Location</label>
                            <div class="col-lg-9">

                                <select name="location_id" type="text" class="form-control select2" required>`;


                             locations.forEach(function(d){
                                html += `<option value="${d.id}" ${corporate.location_id==d.id?'selected':''}>${d.name}</option>`;
                            });



                             html += `

                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                    <button type="submit" class="btn btn-primary">Update</button>
                </div>

                </form>`;


            $("#EditCorporateModal .modal-body #EditCorporateModalBody").html(html);

            $("#EditCorporateModal").modal("show");
            $(".select2").select2();
        });



    </script>


@endsection



