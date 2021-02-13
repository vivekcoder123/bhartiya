

<div class="col-md-6">
    <div class="form-group row ">
        <label for="txtCompanyShipping" class="col-lg-3 col-form-label">Bank</label>
        <div class="col-lg-9">
            
            <select name="bank" class="form-control select2" required>
                <option selected default>Select</option>
                @foreach($service->banks as $bank)
                <option value="{{$bank->name}}">{{$bank->name}}</option>
                @endforeach
            </select>
            
        </div>
    </div>
</div>