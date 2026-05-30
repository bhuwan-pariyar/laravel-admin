<?php

namespace App\Livewire\Damage;

use App\Models\DamageReport;
use App\Models\Store;
use App\Models\Item;
use App\Models\StoreItem;
use App\Models\ActivityLog;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Form extends Component
{
    public $store_id = '';
    public $item_id = '';
    public $quantity = 1;
    public $remarks = '';

    public $current_stock = 0;

    protected function rules()
    {
        return [
            'store_id' => 'required|exists:stores,id',
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'remarks' => 'nullable|string|max:500',
        ];
    }

    public function updatedStoreId()
    {
        $this->updateStock();
    }

    public function updatedItemId()
    {
        $this->updateStock();
    }

    public function updateStock()
    {
        if ($this->store_id && $this->item_id) {
            $storeItem = StoreItem::where('store_id', $this->store_id)
                ->where('item_id', $this->item_id)
                ->first();
            $this->current_stock = $storeItem ? $storeItem->stock_quantity : 0;
        } else {
            $this->current_stock = 0;
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->quantity > $this->current_stock) {
            session()->flash('error', 'Quantity reported damaged cannot exceed available stock in selected store. Current stock: ' . $this->current_stock);
            return;
        }

        DB::transaction(function () {
            // Create Damage Report
            $report = DamageReport::create([
                'store_id' => $this->store_id,
                'item_id' => $this->item_id,
                'quantity' => $this->quantity,
                'reported_by' => auth()->id(),
                'remarks' => $this->remarks,
            ]);

            // Deduct from store stock
            $storeItem = StoreItem::where('store_id', $this->store_id)
                ->where('item_id', $this->item_id)
                ->first();
            if ($storeItem) {
                $storeItem->decrement('stock_quantity', $this->quantity);
            }

            // Deduct from global item stock
            $item = Item::find($this->item_id);
            if ($item) {
                $item->decrement('stock_quantity', $this->quantity);
            }

            // Log activity
            ActivityLog::log('Damage Report', 'Item: ' . $item->name . ' - Quantity: ' . $this->quantity . ' reported damaged at ' . $report->store->name);

            // Trigger notification
            if (auth()->check()) {
                auth()->user()->notify(new \App\Notifications\SystemNotification(
                    'Damage Reported',
                    'Item: ' . $item->name . ' - Quantity: ' . $this->quantity . ' reported damaged at ' . $report->store->name,
                    'error',
                    'fa-solid fa-house-damage'
                ));
            }
        });

        session()->flash('message', 'Damage Report Logged Successfully.');
        session()->flash('alert-type', 'success');

        return $this->redirectRoute('damage.list');
    }

    public function render()
    {
        return view('livewire.damage.form', [
            'stores' => Store::where('status', true)->get(),
            'items' => Item::where('status', true)->get(),
        ]);
    }
}
