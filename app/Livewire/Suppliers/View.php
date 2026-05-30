<?php

namespace App\Livewire\Suppliers;

use App\Models\Supplier;
use Livewire\Component;

class View extends Component
{
    public $supplier;

    public function mount($supplierId)
    {
        $this->supplier = Supplier::findOrFail($supplierId);
    }

    public function render()
    {
        return view('livewire.suppliers.view');
    }
}
