<?php

namespace App\Livewire\Sales;

use App\Models\Sale;
use Livewire\Component;

class View extends Component
{
    public Sale $sale;

    public function mount(int $saleId)
    {
        $this->sale = Sale::with(['customer', 'store', 'items.item'])->findOrFail($saleId);
    }

    public function render()
    {
        return view('livewire.sales.view');
    }
}
