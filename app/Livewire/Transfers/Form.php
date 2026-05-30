<?php

namespace App\Livewire\Transfers;

use App\Models\Transfer;
use App\Models\Store;
use App\Models\Item;
use App\Models\StoreItem;
use App\Models\ActivityLog;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Form extends Component
{
    public $from_store_id = '';
    public $to_store_id = '';
    public $transfer_no = '';
    public $transfer_date = '';
    public $remarks = '';

    public $selected_items = []; // Array of arrays: ['item_id' => ..., 'quantity' => ..., 'stock' => ...]

    public function mount()
    {
        $this->transfer_no = 'TRF-' . strtoupper(uniqid());
        $this->transfer_date = date('Y-m-d');
        $this->addItemRow();
    }

    public function addItemRow()
    {
        $this->selected_items[] = [
            'item_id' => '',
            'quantity' => 1,
            'stock' => 0
        ];
    }

    public function removeItemRow($index)
    {
        unset($this->selected_items[$index]);
        $this->selected_items = array_values($this->selected_items);
    }

    public function updatedFromStoreId()
    {
        $this->updateStockLevels();
    }

    public function updateStockLevels()
    {
        if (!$this->from_store_id) return;

        foreach ($this->selected_items as $index => $row) {
            if ($row['item_id']) {
                $storeItem = StoreItem::where('store_id', $this->from_store_id)
                    ->where('item_id', $row['item_id'])
                    ->first();
                $this->selected_items[$index]['stock'] = $storeItem ? $storeItem->stock_quantity : 0;
            }
        }
    }

    public function updatedSelectedItems($value, $key)
    {
        $parts = explode('.', $key);
        if (count($parts) === 2) {
            $index = $parts[0];
            $field = $parts[1];

            if ($field === 'item_id') {
                $item_id = $value;
                if ($item_id && $this->from_store_id) {
                    $storeItem = StoreItem::where('store_id', $this->from_store_id)
                        ->where('item_id', $item_id)
                        ->first();
                    $this->selected_items[$index]['stock'] = $storeItem ? $storeItem->stock_quantity : 0;
                } else {
                    $this->selected_items[$index]['stock'] = 0;
                }
            }
        }
    }

    public function save()
    {
        $this->validate([
            'from_store_id' => 'required|exists:stores,id',
            'to_store_id' => 'required|exists:stores,id|different:from_store_id',
            'transfer_no' => 'required|string|unique:transfers,transfer_no',
            'transfer_date' => 'required|date',
            'selected_items' => 'required|array|min:1',
            'selected_items.*.item_id' => 'required|exists:items,id',
            'selected_items.*.quantity' => 'required|integer|min:1',
        ], [
            'to_store_id.different' => 'Source and destination store must be different.'
        ]);

        // Verify stock availability at source
        foreach ($this->selected_items as $row) {
            $storeItem = StoreItem::where('store_id', $this->from_store_id)
                ->where('item_id', $row['item_id'])
                ->first();
            $available = $storeItem ? $storeItem->stock_quantity : 0;

            if ($row['quantity'] > $available) {
                $item = Item::find($row['item_id']);
                session()->flash('error', 'Insufficient stock for ' . ($item ? $item->name : 'item') . ' at source. Available: ' . $available);
                return;
            }
        }

        DB::transaction(function () {
            // Create Transfer record
            $transfer = Transfer::create([
                'from_store_id' => $this->from_store_id,
                'to_store_id' => $this->to_store_id,
                'transfer_no' => $this->transfer_no,
                'transfer_date' => $this->transfer_date,
                'status' => 'completed', // auto-complete simple transfers
                'remarks' => $this->remarks,
                'created_by' => auth()->id(),
            ]);

            // Save items and adjust stock levels
            foreach ($this->selected_items as $row) {
                $transfer->items()->create([
                    'item_id' => $row['item_id'],
                    'quantity' => $row['quantity'],
                ]);

                // Deduct from source store stock
                $sourceStoreItem = StoreItem::where('store_id', $this->from_store_id)
                    ->where('item_id', $row['item_id'])
                    ->first();
                if ($sourceStoreItem) {
                    $sourceStoreItem->decrement('stock_quantity', $row['quantity']);
                }

                // Increment destination store stock
                $destStoreItem = StoreItem::firstOrCreate([
                    'store_id' => $this->to_store_id,
                    'item_id' => $row['item_id']
                ]);
                $destStoreItem->increment('stock_quantity', $row['quantity']);
            }

            // Log activity
            ActivityLog::log('Stock Transfer', 'Transfer No: ' . $transfer->transfer_no . ' from Store #' . $this->from_store_id . ' to Store #' . $this->to_store_id);
        });

        session()->flash('message', 'Stock Transferred Successfully.');
        session()->flash('alert-type', 'success');

        return $this->redirectRoute('transfers.list');
    }

    public function render()
    {
        return view('livewire.transfers.form', [
            'stores' => Store::where('status', true)->get(),
            'items' => Item::where('status', true)->get(),
        ]);
    }
}
