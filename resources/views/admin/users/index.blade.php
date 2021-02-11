@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mt-3">
                <div class="card-body">
                    <div class="card-title">
                        Users List
                        <button style="float: right; font-weight: 900;" class="btn btn-primary  mb-2" type="button"  data-toggle="modal" data-target="#createUserModal">
                            Create New User
                        </button>
                    </div>
                    <div class="table-responsive">

                <table class="table table-bordered table-striped" id="datatable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile Number</th>
                            <th>Status</th>
                            <th>Date Of Birth</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{$user->first_name}} {{$user->last_name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->mobile_number}}</td>
                            <td id="updateMessage{{$user->id}}">{{$user->status?"Active":"Not Active"}}</td>
                            <td>{{$user->dob}}</td>
                            <td>{{$user->address}}</td>
                            
                            <td>

                                <button type="button" class="btn btn-success btn-sm getEditUserData" id="getEditUserData" data-value="{{collect($user)}}" data-user_id="{{$user->id}}"><i class="fa fa-edit"> Edit</i></button>
                                <button type="button" class="btn btn-warning btn-sm " id="getUpdateId" data-id="{{$user->id}}"><i class="ti-loop"> Change Status</i></button>

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



<div class="modal fade show" id="createUserModal" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title mt-0" id="exampleModalLabel">Create New User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <form class="needs-validation was-validated" action="{{route('users.store')}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">First Name</label>
                        <input type="text" class="form-control" id="validationCustom01" placeholder="First Name" name="first_name" required="">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter User Name.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">Last Name</label>
                        <input type="text" class="form-control" id="validationCustom07" placeholder="Last Name" name="last_name" required="">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter User Name.</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom01">Email Id</label>
                        <input type="email" class="form-control" id="validationCustom02" placeholder="Enter Email Id" name="email" required="">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter User Eamil Id.</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom01">Mobile Number</label>
                        <input type="number" class="form-control" id="validationCustom08" placeholder="Enter Mobile Number" name="mobile_number" required="">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter Mobile Number</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom01">Password</label>
                        <input type="password" class="form-control" id="validationCustom03" placeholder="Password" name="password" required="">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter Password.</div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="validationCustom01">Address</label>
                        <textarea id="validationCustom05" name="address" rows="4" class="form-control" required></textarea>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter Address.</div>
                    </div>
                    
                    <div class="col-md-12 mb-3 ">
                        <label for="validationCustom01" class="col-form-label">PAN Card</label>
                        
                        <input type="file" class="form-control-file" name="pan[]" id="validationCustom04" multiple required>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please Upload Document.</div>
                        
                    </div><!--end form-group-->
                </div>
                <button class="btn btn-gradient-primary" type="submit">Save User</button>
                </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>


<div class="modal" id="EditUserModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">User Edit</h4>
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
                    <strong>Success!</strong> User was updated successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="EditUserModalBody">
                    
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Change Status User Modal -->
<div class="modal" id="StatusUserModal">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <!-- Modal body -->
            <div class="modal-body">
                <h4>User Status Changed Successfully.</h4>
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
        

        $(".getEditUserData").on("click",function(){
            var user = $(this).data("value");
            var user_id = $(this).data("user_id");

            var html = `<form class="needs-validation was-validated" action="{{url('admin/users/update/${user_id}')}}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">First Name</label>
                        <input type="text" class="form-control" id="validationCustom01" placeholder="First Name" name="first_name" required="" value="${user.first_name}">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter User Name.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="validationCustom01">Last Name</label>
                        <input type="text" class="form-control" id="validationCustom07" placeholder="Last Name" name="last_name" required="" value="${user.last_name}">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter User Name.</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom01">Email Id</label>
                        <input type="email" class="form-control" id="validationCustom02" placeholder="Enter Email Id" name="email" required="" value="${user.email}">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter User Eamil Id.</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom01">Mobile Number</label>
                        <input type="number" class="form-control" id="validationCustom08" placeholder="Enter Mobile Number" name="mobile_number" required="" value="${user.mobile_number}">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter Mobile Number</div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label for="validationCustom01">Password</label>
                        <input type="password" class="form-control" id="validationCustom03" placeholder="Password" name="password" required="">
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter Password.</div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="validationCustom01">Address</label>
                        <textarea id="validationCustom05" name="address" rows="4" class="form-control">${user.address}</textarea>
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please enter Address.</div>
                    </div>
                    
                    <div class="col-md-12 mb-3 ">
                        <label for="validationCustom01" class="col-form-label">PAN Card</label>
                        
                        <input type="file" class="form-control-file" name="pan[]" id="validationCustom04" multiple >
                        <div class="valid-feedback">Looks good!</div>
                        <div class="invalid-feedback">Please Upload Document.</div>
                        
                    </div>
                    `;

                          if(user.pan.length>0){
                            var pan = user.pan.split(',');

                            
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
                                            <input type="" class="get_user_id" value="${user.id}" hidden>
                                            <button class="btn btn-danger deleteImage" id="${i}" type="button" data-value="pan">Remove</button>
                                          </div>
                                        </div>
                                    </div>
                                </div>`;
                            })
                            
                            
                          }
                          
                html+=`</div>
                <button class="btn btn-gradient-primary" type="submit">Update User</button>
                </form>`;
            
            console.log('modal',html);
            $("#EditUserModal .modal-body #EditUserModalBody").html(html);
            
            $("#EditUserModal").modal("show");
        });

        //delete User
        // var deleteID;
        // $('body').on('click', '#getDeleteId', function(){
        //     deleteID = $(this).data('id');
        // })
        // $('#SubmitDeleteUserForm').click(function(e) {
        //     e.preventDefault();
        //     var id = deleteID;
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
        //     $.ajax({
        //         url: "/admin/Users/"+id,
        //         method: 'DELETE',
        //         data:{"_token": "{{ csrf_token() }}"},
        //         success: function(result) {
        //             console.log(result);
        //             $('#DeleteUserModal').modal('hide');
        //             //window.location.reload();
        //         }
        //     });
        // });


        $(document).on("click","#getUpdateId",function(){
                id = $(this).data('id');
                
                $.ajax({
                    method:'POST',
                    url:`/admin/users/change-status`,
                    data:{id,"_token":"{{csrf_token()}}"}
                }).then(response=>{
                  if(response == '1'){
                    $('#updateMessage'+id).text('Active');
                    $('#StatusUserModal').modal('show');
                    setInterval(function(){ 
                            $('#StatusUserModal').modal('hide');
                    }, 4000);
                  }
                  if(response == '0'){
                    $('#updateMessage'+id).text('Not Active');
                    $('#StatusUserModal').modal('show');
                    setInterval(function(){ 
                            $('#StatusUserModal').modal('hide');
                    }, 4000);
                  }
                }).fail(error=>{
                    console.log('error',error);
                });
            });


        $(document).on("click",".deleteImage",function(){
                const el = this;
                const user_id = $('.get_user_id').val();
                const image_name=this.id;
                $.ajax({
                    method:'POST',
                    url:`/admin/users/getDeleteSelectedImages`,
                    data:{image_name,user_id,"_token":"{{csrf_token()}}"},
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
