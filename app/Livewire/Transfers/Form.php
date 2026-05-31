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
    public ?int $transferId = null;
    public ?Transfer $transfer = null;

    public $from_store_id = '';
    public $to_store_id = '';
    public $transfer_no = '';
    public $transfer_date = '';
    public $remarks = '';

    public $selected_items = []; // Array of arrays: ['item_id' => ..., 'quantity' => ..., 'stock' => ...]

    public function mount(?int $transferId = null)
    {
        if ($transferId) {
            $this->transfer = Transfer::findOrFail($transferId);
            $this->transferId = $this->transfer->id;
            $this->from_store_id = $this->transfer->from_store_id;
            $this->to_store_id = $this->transfer->to_store_id;
            $this->transfer_no = $this->transfer->transfer_no;
            $this->transfer_date = $this->transfer->transfer_date ? $this->transfer->transfer_date->format('Y-m-d') : '';
            $this->remarks = $this->transfer->remarks;

            $this->selected_items = [];
            foreach ($this->transfer->items as $item) {
                $storeItem = StoreItem::where('store_id', $this->from_store_id)
                    ->where('item_id', $item->item_id)
                    ->first();
                $baseStock = $storeItem ? $storeItem->stock_quantity : 0;
                $this->selected_items[] = [
                    'item_id' => $item->item_id,
                    'quantity' => $item->quantity,
                    'stock' => $baseStock + $item->quantity,
                ];
            }
        } else {
            $this->transfer_no = 'TRF-' . strtoupper(uniqid());
            $this->transfer_date = date('Y-m-d');
            $this->addItemRow();
        }
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
                $baseStock = $storeItem ? $storeItem->stock_quantity : 0;
                if ($this->transfer && 
                    $this->from_store_id == $this->transfer->getOriginal('from_store_id')) {
                    $originalItem = $this->transfer->items()->where('item_id', $row['item_id'])->first();
                    if ($originalItem) {
                        $baseStock += $originalItem->quantity;
                    }
                }
                $this->selected_items[$index]['stock'] = $baseStock;
            }
        }
    }

    public function updated($name, $value)
    {
        if (str_starts_with($name, 'selected_items.')) {
            $parts = explode('.', $name);
            if (count($parts) === 3) {
                $index = $parts[1];
                $field = $parts[2];

                if (isset($this->selected_items[$index])) {
                    if ($field === 'item_id') {
                        $item_id = $value;
                        if ($item_id && $this->from_store_id) {
                            $storeItem = StoreItem::where('store_id', $this->from_store_id)
                                ->where('item_id', $item_id)
                                ->first();
                            $baseStock = $storeItem ? $storeItem->stock_quantity : 0;
                            if ($this->transfer && 
                                $this->from_store_id == $this->transfer->getOriginal('from_store_id')) {
                                $originalItem = $this->transfer->items()->where('item_id', $item_id)->first();
                                if ($originalItem) {
                                    $baseStock += $originalItem->quantity;
                                }
                            }
                            $this->selected_items[$index]['stock'] = $baseStock;
                        } else {
                            $this->selected_items[$index]['stock'] = 0;
                        }
                    }
                }
            }
        }
    }

    public function save()
    {
        $this->validate([
            'from_store_id' => 'required|exists:stores,id',
            'to_store_id' => 'required|exists:stores,id|different:from_store_id',
            'transfer_no' => 'required|string|unique:transfers,transfer_no,' . ($this->transferId ?? 'NULL') . ',id',
            'transfer_date' => 'required|date',
            'selected_items' => 'required|array|min:1',
            'selected_items.*.item_id' => 'required|exists:items,id',
            'selected_items.*.quantity' => 'required|integer|min:1',
        ], [
            'to_store_id.different' => 'Source and destination store must be different.'
        ]);

        // Verify stock availability at source
        foreach ($this->selected_items as $row) {
            if ($row['quantity'] > $row['stock']) {
                $item = Item::find($row['item_id']);
                session()->flash('error', 'Insufficient stock for ' . ($item ? $item->name : 'item') . ' at source. Available: ' . $row['stock']);
                return;
            }
        }

        // Verify destination stock revert
        if ($this->transferId) {
            foreach ($this->transfer->items as $oldItem) {
                $oldDestStoreItem = StoreItem::where('store_id', $this->transfer->getOriginal('to_store_id'))
                    ->where('item_id', $oldItem->item_id)
                    ->first();
                $currentDestStock = $oldDestStoreItem ? $oldDestStoreItem->stock_quantity : 0;
                
                $newQty = 0;
                $destChanged = ($this->to_store_id != $this->transfer->getOriginal('to_store_id'));
                if (!$destChanged) {
                    foreach ($this->selected_items as $newRow) {
                        if ($newRow['item_id'] == $oldItem->item_id) {
                            $newQty += $newRow['quantity'];
                        }
                    }
                }
                $netDestStock = $currentDestStock - $oldItem->quantity + $newQty;
                if ($netDestStock < 0) {
                    $itemModel = Item::find($oldItem->item_id);
                    session()->flash('error', 'Cannot update transfer. Reverting/decreasing this transfer would result in negative stock (' . $netDestStock . ') at destination for item: ' . ($itemModel ? $itemModel->name : 'item'));
                    return;
                }
            }
        }

        DB::transaction(function () {
            if ($this->transferId) {
                // Revert original stock transfer
                foreach ($this->transfer->items as $oldItem) {
                    $oldFromStoreItem = StoreItem::where('store_id', $this->transfer->getOriginal('from_store_id'))
                        ->where('item_id', $oldItem->item_id)
                        ->first();
                    if ($oldFromStoreItem) {
                        $oldFromStoreItem->increment('stock_quantity', $oldItem->quantity);
                    }
                    
                    $oldToStoreItem = StoreItem::where('store_id', $this->transfer->getOriginal('to_store_id'))
                        ->where('item_id', $oldItem->item_id)
                        ->first();
                    if ($oldToStoreItem) {
                        $oldToStoreItem->decrement('stock_quantity', $oldItem->quantity);
                    }
                }
                $this->transfer->items()->delete();

                $this->transfer->update([
                    'from_store_id' => $this->from_store_id,
                    'to_store_id' => $this->to_store_id,
                    'transfer_no' => $this->transfer_no,
                    'transfer_date' => $this->transfer_date,
                    'remarks' => $this->remarks,
                ]);
                $transfer = $this->transfer;
            } else {
                $transfer = Transfer::create([
                    'from_store_id' => $this->from_store_id,
                    'to_store_id' => $this->to_store_id,
                    'transfer_no' => $this->transfer_no,
                    'transfer_date' => $this->transfer_date,
                    'status' => 'completed',
                    'remarks' => $this->remarks,
                    'created_by' => auth()->id(),
                ]);
            }

            foreach ($this->selected_items as $row) {
                $transfer->items()->create([
                    'item_id' => $row['item_id'],
                    'quantity' => $row['quantity'],
                ]);

                $sourceStoreItem = StoreItem::where('store_id', $this->from_store_id)
                    ->where('item_id', $row['item_id'])
                    ->first();
                if ($sourceStoreItem) {
                    $sourceStoreItem->decrement('stock_quantity', $row['quantity']);
                }

                $destStoreItem = StoreItem::firstOrCreate([
                    'store_id' => $this->to_store_id,
                    'item_id' => $row['item_id']
                ]);
                $destStoreItem->increment('stock_quantity', $row['quantity']);
            }

            if ($this->transferId) {
                ActivityLog::log('Update Transfer', 'Transfer No: ' . $transfer->transfer_no . ' from Store #' . $this->from_store_id . ' to Store #' . $this->to_store_id . ' updated.');
            } else {
                ActivityLog::log('Stock Transfer', 'Transfer No: ' . $transfer->transfer_no . ' from Store #' . $this->from_store_id . ' to Store #' . $this->to_store_id);
            }
        });

        session()->flash('message', $this->transferId ? 'Stock Transfer Updated Successfully.' : 'Stock Transferred Successfully.');
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
