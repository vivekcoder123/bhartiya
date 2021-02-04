<?php

namespace App\Http\Livewire;
use App\Models\Bank as BankModel;
use Livewire\Component;

class Bank extends Component
{
    public $data, $name, $selected_id;
    public $updateMode = false;

    public function render()
    {
        $this->data = BankModel::all();
        return view('livewire.bank.index');
    }
    private function resetInput()
    {
        $this->name = null;
    }
    public function store()
    {
        $this->validate([
            'name' => 'required'
        ]);
        BankModel::create([
            'name' => $this->name
        ]);
        $this->resetInput();
    }
    public function edit($id)
    {
        $record = BankModel::findOrFail($id);
        $this->selected_id = $id;
        $this->name = $record->name;
        $this->updateMode = true;
    }
    public function update()
    {
        $this->validate([
            'selected_id' => 'required|numeric',
            'name' => 'required'
        ]);
        if ($this->selected_id) {
            $record = BankModel::find($this->selected_id);
            $record->update([
                'name' => $this->name
            ]);
            $this->resetInput();
            $this->updateMode = false;
        }
    }
    public function destroy($id)
    {
        if ($id) {
            $record = BankModel::where('id', $id);
            $record->delete();
        }
    }
}
