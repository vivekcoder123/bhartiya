<div>
    <div class="form-group col-md-6 d-inline-block">
        <label for="exampleInputPassword1">Bank Name</label>
        <input type="text" wire:model="name" class="form-control input-sm"  placeholder="Name">
    </div>
    <button wire:click="store()" class="btn btn-primary">Add</button>
</div>