<?php

namespace App\Livewire\Purchases;

use App\Models\Purchase;
use Livewire\Component;

class View extends Component
{
    public Purchase $purchase;

    public function mount(int $purchaseId)
    {
        $this->purchase = Purchase::with(['supplier', 'store', 'items.item'])->findOrFail($purchaseId);
    }

    public function render()
    {
        return view('livewire.purchases.view');
    }
}
