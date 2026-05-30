<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use Livewire\Component;

class Form extends Component
{
    public ?int $customerId = null;
    public ?Customer $customer = null;

    public $name = '';
    public $email = '';
    public $phone = '';
    public $address = '';
    public $status = true;

    public function mount(?int $customerId = null)
    {
        if ($customerId) {
            $this->customer = Customer::findOrFail($customerId);
            $this->customerId = $this->customer->id;

            $this->fill([
                'name' => $this->customer->name,
                'email' => $this->customer->email,
                'phone' => $this->customer->phone,
                'address' => $this->customer->address,
                'status' => $this->customer->status,
            ]);
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        if ($this->customerId) {
            $this->customer->update($validated);
            session()->flash('message', 'Customer Updated Successfully.');
        } else {
            Customer::create($validated);
            session()->flash('message', 'Customer Created Successfully.');
        }

        session()->flash('alert-type', 'success');

        return $this->redirectRoute('customers.list');
    }

    public function render()
    {
        return view('livewire.customers.form');
    }
}
