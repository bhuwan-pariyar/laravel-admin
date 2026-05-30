<?php

namespace App\Livewire\Stores;

use App\Models\Store;
use Livewire\Component;
use Illuminate\Validation\Rule;

class Form extends Component
{
    public ?int $storeId = null;
    public ?Store $store = null;

    public $name = '';
    public $code = '';
    public $location = '';
    public $status = true;

    public function mount(?int $storeId = null)
    {
        if ($storeId) {
            $this->store = Store::findOrFail($storeId);
            $this->storeId = $this->store->id;

            $this->fill([
                'name' => $this->store->name,
                'code' => $this->store->code,
                'location' => $this->store->location,
                'status' => $this->store->status,
            ]);
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('stores', 'code')->ignore($this->storeId),
            ],
            'location' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        if ($this->storeId) {
            $this->store->update($validated);
            session()->flash('message', 'Store Updated Successfully.');
        } else {
            Store::create($validated);
            session()->flash('message', 'Store Created Successfully.');
        }

        session()->flash('alert-type', 'success');

        return $this->redirectRoute('stores.list');
    }

    public function render()
    {
        return view('livewire.stores.form');
    }
}
