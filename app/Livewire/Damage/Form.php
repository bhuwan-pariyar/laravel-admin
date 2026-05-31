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
    public ?int $damageId = null;
    public ?DamageReport $damageReport = null;
    public int $original_quantity = 0;

    public $store_id = '';
    public $item_id = '';
    public $quantity = 1;
    public $remarks = '';

    public $current_stock = 0;

    public function mount(?int $damageId = null)
    {
        if ($damageId) {
            $this->damageReport = DamageReport::findOrFail($damageId);
            $this->damageId = $this->damageReport->id;
            $this->store_id = $this->damageReport->store_id;
            $this->item_id = $this->damageReport->item_id;
            $this->quantity = $this->damageReport->quantity;
            $this->remarks = $this->damageReport->remarks;
            $this->original_quantity = $this->damageReport->quantity;
        }
        $this->updateStock();
    }

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
            $baseStock = $storeItem ? $storeItem->stock_quantity : 0;

            if ($this->damageReport && 
                $this->store_id == $this->damageReport->getOriginal('store_id') && 
                $this->item_id == $this->damageReport->getOriginal('item_id')) {
                $this->current_stock = $baseStock + $this->original_quantity;
            } else {
                $this->current_stock = $baseStock;
            }
        } else {
            $this->current_stock = 0;
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->quantity > $this->current_stock) {
            session()->flash('error', 'Quantity reported damaged cannot exceed available stock in selected store. Available stock: ' . $this->current_stock);
            return;
        }

        DB::transaction(function () {
            if ($this->damageId) {
                // 1. Revert original stock deduction
                $oldStoreId = $this->damageReport->getOriginal('store_id');
                $oldItemId = $this->damageReport->getOriginal('item_id');
                $oldQuantity = $this->damageReport->getOriginal('quantity');

                $oldStoreItem = StoreItem::where('store_id', $oldStoreId)
                    ->where('item_id', $oldItemId)
                    ->first();
                if ($oldStoreItem) {
                    $oldStoreItem->increment('stock_quantity', $oldQuantity);
                }
                $oldItem = Item::find($oldItemId);
                if ($oldItem) {
                    $oldItem->increment('stock_quantity', $oldQuantity);
                }

                // 2. Deduct from new store stock
                $newStoreItem = StoreItem::firstOrCreate([
                    'store_id' => $this->store_id,
                    'item_id' => $this->item_id,
                ], ['stock_quantity' => 0]);
                $newStoreItem->decrement('stock_quantity', $this->quantity);

                // Deduct from new global item stock
                $item = Item::find($this->item_id);
                if ($item) {
                    $item->decrement('stock_quantity', $this->quantity);
                }

                // 3. Update Damage Report
                $this->damageReport->update([
                    'store_id' => $this->store_id,
                    'item_id' => $this->item_id,
                    'quantity' => $this->quantity,
                    'remarks' => $this->remarks,
                ]);

                // Log activity
                ActivityLog::log('Damage Report Updated', 'Item: ' . $item->name . ' - Quantity: ' . $this->quantity . ' (was ' . $oldQuantity . ') at ' . $this->damageReport->store->name);

                session()->flash('message', 'Damage Report Updated Successfully.');
            } else {
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
                ActivityLog::log('Damage Report Logged', 'Item: ' . $item->name . ' - Quantity: ' . $this->quantity . ' reported damaged at ' . $report->store->name);

                // Trigger notification
                if (auth()->check()) {
                    auth()->user()->notify(new \App\Notifications\SystemNotification(
                        'Damage Reported',
                        'Item: ' . $item->name . ' - Quantity: ' . $this->quantity . ' reported damaged at ' . $report->store->name,
                        'error',
                        'fa-solid fa-house-damage'
                    ));
                }

                session()->flash('message', 'Damage Report Logged Successfully.');
            }
        });

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
