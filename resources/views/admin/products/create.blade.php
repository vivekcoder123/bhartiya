@extends('layouts.admin')


@section('css')

<style>
    .variant_remove{
        margin-top: 33px;
    }
    .product_variant{
       margin-bottom: 30px;
       padding-bottom: 20px;
       border-bottom: 2px solid rebeccapurple;
    }
    
</style>

@stop


@section('content')

<div class="pd-20 card-box mb-30">
    <div class="clearfix">
        <div class="pull-left mb-20">
            <h4 class="text-dark h4">Create Product</h4>
            
        </div>
        
    </div>
    <form class="form-horizontal" action="{{route('products.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Product Name</label>
            <div class="col-sm-12 col-md-10">
                <input class="form-control" type="text" name="name" placeholder="Name" required>
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Description</label>
            <div class="col-sm-12 col-md-10 html-editor">
                <textarea rows="2" name="description" class="textarea_editor form-control border-radius-0" required></textarea>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">SKU</label>
            <div class="col-sm-12 col-md-10">
                <input class="form-control" type="text" name="sku" required>
            </div>
        </div>

        <div class="form-group row ">
            <label class="col-sm-12 col-md-2 col-form-label">Category</label>
            <div class="col-sm-12 col-md-10">
              <select class="custom-select col-12" name="category_id" required>
                <option selected disabled>Select</option>
                @foreach($categories as $category)
                <option value="{{$category->id}}" {{$category->id==Request::old('category_id')?"selected":""}}>{{$category->name}}</option>
                @endforeach
              </select>
            </div>
         </div>


         <div class="add_varient">
            
         </div>


         <div class="row text-center">
            <button class="btn btn-primary variant mx-auto mb-20" type="button"><i class="icon-copy dw dw-add"></i> Add Product Variants</button>
         </div>

         <div class="form-group row">
            <label class="col-sm-12 col-md-2 col-form-label">Images</label>
            <div class="col-sm-12 col-md-10">
               <input type="file" multiple name="images[]" class="form-control-file form-control height-auto" required>
            </div>
         </div>

        <button class="btn btn-success" type="submit">Create</button>

    </form>
    
</div>

@stop


@section('js')

        <script type="text/javascript">

            $(document).on("click",".variant",function(){
                
                  $(".add_varient").append(`<div class='row product_variant'>
                        <div class='form-group col-md-3 col-sm-6'>
                           <label>Unit Name</label>
                           <select class='custom-select ' name='unit_id[]' required>
                              <option selected disabled>Select</option>
                              @foreach($units as $unit)<option value='{{$unit->id}}' {{$unit->id==Request::old('unit_id')?'selected':''}}>{{$unit->name}}</option>@endforeach
                           </select>
                        </div>
                        <div class='col-md-3 col-sm-6'>
                           <div class='form-group'><label>Quantity</label><input type='number' name='quantity[]' class='form-control' required></div>
                        </div>
                        <div class='col-md-2 col-sm-6'>
                           <div class='form-group'><label>MRP Price</label><input type='number' name='mrp_price[]' class='form-control' required></div>
                        </div>
                        <div class='col-md-2 col-sm-6'>
                           <div class='form-group'><label>Selling Price</label><input type='number' name='selling_price[]' class='form-control' required></div>
                        </div>
                        
                        <div class='col-md-2 col-sm-12'>
                           <button class="btn btn-danger variant_remove mx-auto" type="button"><i class="icon-copy dw dw-trash"></i></button>
                        </div>
                        
                     </div>`);

                  //$("select").select2();
            });


            $(document).on("click",".variant_remove",function(){
               
               $(this).parent().parent().fadeOut(function(){
                  $(this).remove();
               }); 
            });



            
        </script>

@stop