<?php

namespace App\Livewire\Customers;

use Livewire\Component;
use App\Models\Customer;

class View extends Component
{
    public $customer;

    public function mount($customerId)
    {
        $this->customer = Customer::findOrFail($customerId);
    }

    public function render()
    {
        return view('livewire.customers.view');
    }
}
