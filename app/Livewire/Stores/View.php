<?php

namespace App\Livewire\Stores;

use Livewire\Component;
use App\Models\Store;

class View extends Component
{
    public $store;

    public function mount($storeId)
    {
        $this->store = Store::findOrFail($storeId);
    }

    public function render()
    {
        return view('livewire.stores.view');
    }
}
