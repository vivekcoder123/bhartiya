@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mt-3">
                <div class="card-body">
                    <div class="card-title">
                        {{ __('Banks List') }}
                        <button style="float: right; font-weight: 900;" class="btn btn-primary mb-2" type="button"  data-toggle="modal" data-target="#CreateBankModal">
                            Create New Bank
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered datatable table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th width="150" class="text-center">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Bank Modal -->
<div class="modal" id="CreateBankModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Bank Create</h4>
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
                    <strong>Success!</strong>Bank was added successfully.
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
                <button type="button" class="btn btn-success" id="SubmitCreateBankForm">Create</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Bank Modal -->
<div class="modal" id="EditBankModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Bank Edit</h4>
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
                    <strong>Success!</strong>Bank was added successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="EditBankModalBody">
                    
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="SubmitEditBankForm">Update</button>
                <button type="button" class="btn btn-danger modelClose" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Bank Modal -->
<div class="modal" id="DeleteBankModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Bank Delete</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <h4>Are you sure want to delete this Bank?</h4>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="SubmitDeleteBankForm">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>

<!-- Change Status Bank Modal -->
<div class="modal" id="StatusBankModal">
    <div class="modal-dialog">
        <div class="modal-content">
        
            <!-- Modal body -->
            <div class="modal-body">
                <h4>Bank Status Changed Successfully.</h4>
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
            ajax: '{{ route('get-banks') }}',
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'status', name: 'status'},
                {data: 'Actions', name: 'Actions',orderable:true,searchable:true,sClass:'text-center'},
            ]
        });

        // Create Bank Ajax request.
        $('#SubmitCreateBankForm').click(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('banks.store') }}",
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
                         
                        $('#CreateBankModal input').val('');
                        setInterval(function(){                        
                            $('.alert-success').hide();
                        }, 3000);
                    }
                }
            });
        });

        // Get single Bank in EditModel
        $('.modelClose').on('click', function(){
            $('#EditBankModal').hide();
        });
        var id;
        $('body').on('click', '#getEditBankData', function(e) {
            // e.preventDefault();
            $('.alert-danger').html('');
            $('.alert-danger').hide();
            id = $(this).data('id');
            $.ajax({
                url: "banks/"+id+"/edit",
                method: 'GET',
                // data: {
                //     id: id,
                // },
                success: function(result) {
                    console.log(result);
                    $('#EditBankModalBody').html(result.html);
                    $('#EditBankModal').show();
                }
            });
        });

        // Update Bank Ajax request.
        $('#SubmitEditBankForm').click(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "banks/"+id,
                method: 'PUT',
                data: {
                    name: $('#editBank').val(),
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

        // Delete Bank Ajax request.
        var deleteID;
        $('body').on('click', '#getDeleteId', function(){
            deleteID = $(this).data('id');
        })
        $('#SubmitDeleteBankForm').click(function(e) {
            e.preventDefault();
            var id = deleteID;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "banks/"+id,
                method: 'DELETE',
                data:{"_token": "{{ csrf_token() }}"},
                success: function(result) {
                    
                        $('.datatable').DataTable().ajax.reload();
                        $('#DeleteBankModal').modal('hide');
                  
                }
            });
        });

        $(document).on("click","#getUpdateId",function(){
            id = $(this).data('id');
            
            $.ajax({
                method:'POST',
                url:`/admin/banks/change-status`,
                data:{id,"_token":"{{csrf_token()}}"}
            }).then(response=>{
              if(response == '1'){
                $('.datatable').DataTable().ajax.reload();
                $('#StatusBankModal').modal('show');
                setInterval(function(){ 
                        $('#StatusBankModal').modal('hide');
                }, 4000);
              }
              if(response == '0'){
                $('.datatable').DataTable().ajax.reload();
                $('#StatusBankModal').modal('show');
                setInterval(function(){ 
                        $('#StatusBankModal').modal('hide');
                }, 4000);
              }
            }).fail(error=>{
                console.log('error',error);
            });
        });

    });
</script>
@stop