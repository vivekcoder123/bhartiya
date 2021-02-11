@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mt-3">
                <div class="card-body">
                    <div class="card-title">
                        {{ __('Designations List') }}
                        <button style="float: right; font-weight: 900;" class="btn btn-primary mb-2" type="button"  data-toggle="modal" data-target="#CreateDesignationModal">
                            Create New Designation
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered datatable">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th width="150" class="text-center">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Designation Modal -->
<div class="modal" id="CreateDesignationModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Designation Create</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="display: none;">
                    <strong>Success!</strong>Designation was added successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" name="name" id="name">
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="SubmitCreateDesignationForm">Create</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Designation Modal -->
<div class="modal" id="EditDesignationModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Designation Edit</h4>
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
                    <strong>Success!</strong>Designation was updated successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="EditDesignationModalBody">
                    
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="SubmitEditDesignationForm">Update</button>
                <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Designation Modal -->
<div class="modal" id="DeleteDesignationModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Designation Delete</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <h4>Are you sure want to delete this Designation?</h4>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="SubmitDeleteDesignationForm">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>


<!-- Change Status Designation Modal -->
<div class="modal" id="StatusDesignationModal">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <!-- Modal body -->
            <div class="modal-body">
                <h4>Designation Status Changed Successfully.</h4>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



@stop

@section('js')

<script type="text/javascript">
  $(document).ready(function() {
        // init datatable.
        var dataTable = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            pageLength: 5,
            // scrollX: true,
            "order": [[ 0, "desc" ]],
            ajax: '{{ route('get-designations') }}',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'status', name: 'status'},
                {data: 'Actions', name: 'Actions',orderable:true,searchable:true,sClass:'text-center'},
            ]
        });

        // Create Designation Ajax request.
        $('#SubmitCreateDesignationForm').click(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('designations.store') }}",
                method: 'post',
                data: {
                    name: $('#name').val(),
                    "_token": "{{ csrf_token() }}"
                },
                success: function(result) {
                    if(result.errors) {
                        $('.alert-danger').html('');
                        $.each(result.errors, function(key, value) {
                            $('.alert-danger').show();
                            $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                        });
                    } else {
                        $('.alert-danger').hide();
                        $('.alert-success').show();
                        $('.datatable').DataTable().ajax.reload();
                         
                        $('#CreateDesignationModal input').val('');
                        setInterval(function(){                        
                            $('.alert-success').hide();
                        }, 3000);
                    }
                }
            });
        });

        // Get single Designation in EditModel
        $('.modelClose').on('click', function(){
            $('#EditDesignationModal').hide();
        });
        var id;
        $('body').on('click', '#getEditDesignationData', function(e) {
            // e.preventDefault();
            $('.alert-danger').html('');
            $('.alert-danger').hide();
            id = $(this).data('id');
            $.ajax({
                url: "designations/"+id+"/edit",
                method: 'GET',
                // data: {
                //     id: id,
                // },
                success: function(result) {
                    console.log(result);
                    $('#EditDesignationModalBody').html(result.html);
                    $('#EditDesignationModal').show();
                }
            });
        });

        // Update Designation Ajax request.
        $('#SubmitEditDesignationForm').click(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "designations/"+id,
                method: 'PUT',
                data: {
                    name: $('#editDesignation').val(),
                    "_token": "{{ csrf_token() }}"
                },
                success: function(result) {
                    if(result.errors) {
                        $('.alert-danger').html('');
                        $.each(result.errors, function(key, value) {
                            $('.alert-danger').show();
                            $('.alert-danger').append('<strong><li>'+value+'</li></strong>');
                        });
                    } else {
                        $('.alert-danger').hide();
                        $('.alert-success').show();
                        $('.datatable').DataTable().ajax.reload();
                        setInterval(function(){ 
                            $('.alert-success').hide();
                        }, 3000);
                    }
                }
            });
        });

        // Delete Designation Ajax request.
        var deleteID;
        $('body').on('click', '#getDeleteId', function(){
            deleteID = $(this).data('id');
        })
        $('#SubmitDeleteDesignationForm').click(function(e) {
            e.preventDefault();
            var id = deleteID;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "designations/"+id,
                method: 'DELETE',
                data:{"_token": "{{ csrf_token() }}"},
                success: function(result) {
                    
                        $('.datatable').DataTable().ajax.reload();
                        $('#DeleteDesignationModal').modal('hide');
                  
                }
            });
        });

        //change Designation status
        $(document).on("click","#getUpdateId",function(){
            id = $(this).data('id');
            
            $.ajax({
                method:'POST',
                url:`/admin/designations/change-status`,
                data:{id,"_token":"{{csrf_token()}}"}
            }).then(response=>{
              if(response == '1'){
                $('.datatable').DataTable().ajax.reload();
                $('#StatusDesignationModal').modal('show');
                setInterval(function(){ 
                        $('#StatusDesignationModal').modal('hide');
                }, 4000);
              }
              if(response == '0'){
                $('.datatable').DataTable().ajax.reload();
                $('#StatusDesignationModal').modal('show');
                setInterval(function(){ 
                        $('#StatusDesignationModal').modal('hide');
                }, 4000);
              }
            }).fail(error=>{
                console.log('error',error);
            });
        });
    });
</script>
@stop