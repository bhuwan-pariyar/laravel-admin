<?php

namespace App\Livewire\Reports;

use App\Models\Item;
use App\Models\Store;
use App\Models\StoreItem;
use Livewire\Component;
use Livewire\WithPagination;

class StockReport extends Component
{
    use WithPagination;

    public $selectedStore = '';
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedStore()
    {
        $this->resetPage();
    }

    public function render()
    {
        $stores = Store::where('status', true)->get();

        $query = Item::with(['category', 'storeItems.store'])
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('sku', 'like', '%' . $this->search . '%');
            });

        if ($this->selectedStore) {
            $query->whereHas('storeItems', function ($q) {
                $q->where('store_id', $this->selectedStore);
            });
        }

        $items = $query->paginate(15);

        // Compute overall stock values
        $totalItems = Item::count();
        $totalStockValuation = Item::selectRaw('SUM(stock_quantity * cost_price) as cost_val')->first()->cost_val ?? 0;
        $totalRetailValuation = Item::selectRaw('SUM(stock_quantity * selling_price) as sale_val')->first()->sale_val ?? 0;

        return view('livewire.reports.stock-report', [
            'items' => $items,
            'stores' => $stores,
            'totalItems' => $totalItems,
            'totalStockValuation' => $totalStockValuation,
            'totalRetailValuation' => $totalRetailValuation,
        ]);
    }
}
