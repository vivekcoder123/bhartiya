@foreach($service->fields as $field)

<div class="col-md-6">
    <div class="form-group row ">
        <label for="txtCompanyShipping" class="col-lg-3 col-form-label">{{$field->show_name}}</label>
        <div class="col-lg-9">
            @if($field->name == 'bank_id' || $field->name == 'propose_bank_id')
            <select name="{{$field->name}}" class="form-control select2" required>
                <option selected>Select</option>
                @foreach($service->banks as $bank)
                <option value="{{$bank->id}}">{{$bank->name}}</option>
                @endforeach
            </select>
            @else
            <input type="{{$field->attribute_type->type}}" class="form-control" name="{{$field->name}}">
            @endif
        </div>
    </div>
</div>
@endforeach
