<div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                
                    
                <div class="col-md-4" style="float:right;">

                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <ul style="list-style-type:none;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                    @if($updateMode)
                        @include('livewire.bank.update')
                    @else
                        @include('livewire.bank.create')
                    @endif
                    <div class="mt-3">
                        <h3 class="mt-0 header-title">Bank List</h3>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Action</th>
                                
                            </tr>
                            </thead>


                            <tbody>
                            @foreach($data as $row)
                            <tr>
                                <td>{{$row->id}}</td>
                                <td>{{$row->name}}</td>
                                <td>

                                    <a wire:click="edit({{$row->id}})"><i class="far fa-edit text-info mr-1"></i></a>
                                    <a wire:click="destroy({{$row->id}})"><i class="far fa-trash-alt text-danger"></i></a>
                                    
                                </td>
                            </tr>
                            @endforeach
                            
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->



