@extends('layouts.admin')

@section('content')
<div class="row">
   <div class="col-sm-12 mt-4">
       <div class="page-title-box">
           <h4 class="page-title">Banks List</h4>
       </div><!--end page-title-box-->
   </div><!--end col-->
</div>
@livewire('bank')

@stop