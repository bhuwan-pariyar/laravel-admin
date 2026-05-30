<?php

namespace App\Livewire\Suppliers;

use App\Models\Supplier;
use Livewire\Component;

class Form extends Component
{
    public ?int $supplierId = null;
    public ?Supplier $supplier = null;

    public $name = '';
    public $email = '';
    public $phone = '';
    public $address = '';
    public $status = true;

    public function mount(?int $supplierId = null)
    {
        if ($supplierId) {
            $this->supplier = Supplier::findOrFail($supplierId);
            $this->supplierId = $this->supplier->id;

            $this->fill([
                'name' => $this->supplier->name,
                'email' => $this->supplier->email,
                'phone' => $this->supplier->phone,
                'address' => $this->supplier->address,
                'status' => $this->supplier->status,
            ]);
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'status' => 'required|boolean',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        if ($this->supplierId) {
            $this->supplier->update($validated);
        } else {
            Supplier::create($validated);
        }

        session()->flash(
            'message',
            $this->supplierId ? 'Supplier Updated Successfully.' : 'Supplier Created Successfully.'
        );

        session()->flash('alert-type', 'success');

        return $this->redirectRoute('suppliers.list');
    }

    public function render()
    {
        return view('livewire.suppliers.form');
    }
}
