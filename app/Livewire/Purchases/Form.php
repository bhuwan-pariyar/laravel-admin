<?php

namespace App\Livewire\Purchases;

use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Store;
use App\Models\Item;
use App\Models\StoreItem;
use App\Models\ActivityLog;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Form extends Component
{
    public ?int $purchaseId = null;
    public ?Purchase $purchase = null;

    public $supplier_id = '';
    public $store_id = '';
    public $purchase_no = '';
    public $purchase_date = '';
    public $payment_status = 'pending';
    public $remarks = '';

    public $selected_items = []; // Array of arrays: ['item_id' => ..., 'quantity' => ..., 'cost' => ..., 'stock' => ...]
    public $tax_rate = 0; // percentage
    public $discount_amount = 0;

    public $subtotal = 0;
    public $tax_amount = 0;
    public $grand_total = 0;

    public function mount(?int $purchaseId = null)
    {
        if ($purchaseId) {
            $this->purchase = Purchase::findOrFail($purchaseId);
            $this->purchaseId = $this->purchase->id;
            $this->supplier_id = $this->purchase->supplier_id;
            $this->store_id = $this->purchase->store_id;
            $this->purchase_no = $this->purchase->purchase_no;
            $this->purchase_date = $this->purchase->purchase_date ? $this->purchase->purchase_date->format('Y-m-d') : '';
            $this->payment_status = $this->purchase->payment_status;
            $this->remarks = $this->purchase->remarks;
            $this->discount_amount = $this->purchase->discount_amount;

            // Load selected items
            $this->selected_items = [];
            foreach ($this->purchase->items as $item) {
                $storeItem = StoreItem::where('store_id', $this->store_id)
                    ->where('item_id', $item->item_id)
                    ->first();
                $baseStock = $storeItem ? $storeItem->stock_quantity : 0;
                $this->selected_items[] = [
                    'item_id' => $item->item_id,
                    'quantity' => $item->quantity,
                    'cost' => $item->cost_price,
                    'stock' => $baseStock - $item->quantity,
                    'total' => $item->total,
                ];
            }
            $subtotal = 0;
            foreach ($this->selected_items as $row) {
                $subtotal += floatval($row['total']);
            }
            if ($subtotal > 0) {
                $this->tax_rate = round(($this->purchase->tax_amount * 100) / $subtotal, 2);
            } else {
                $this->tax_rate = 0;
            }
            $this->calculateTotals();
        } else {
            $this->purchase_no = 'PUR-' . strtoupper(uniqid());
            $this->purchase_date = date('Y-m-d');
            $this->addItemRow();
        }
    }

    public function addItemRow()
    {
        $this->selected_items[] = [
            'item_id' => '',
            'quantity' => 1,
            'cost' => 0,
            'stock' => 0,
            'total' => 0
        ];
    }

    public function removeItemRow($index)
    {
        unset($this->selected_items[$index]);
        $this->selected_items = array_values($this->selected_items);
        $this->calculateTotals();
    }

    public function updatedStoreId()
    {
        $this->updateStockLevels();
    }

    public function updateStockLevels()
    {
        if (!$this->store_id) return;

        foreach ($this->selected_items as $index => $row) {
            if ($row['item_id']) {
                $storeItem = StoreItem::where('store_id', $this->store_id)
                    ->where('item_id', $row['item_id'])
                    ->first();
                $baseStock = $storeItem ? $storeItem->stock_quantity : 0;
                if ($this->purchase && 
                    $this->store_id == $this->purchase->getOriginal('store_id')) {
                    $originalItem = $this->purchase->items()->where('item_id', $row['item_id'])->first();
                    if ($originalItem) {
                        $baseStock -= $originalItem->quantity;
                    }
                }
                $this->selected_items[$index]['stock'] = $baseStock;
            }
        }
        $this->calculateTotals();
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
                        if ($item_id) {
                            $item = Item::find($item_id);
                            if ($item) {
                                $this->selected_items[$index]['cost'] = $item->cost_price;
                                
                                if ($this->store_id) {
                                    $storeItem = StoreItem::where('store_id', $this->store_id)
                                        ->where('item_id', $item_id)
                                        ->first();
                                    $baseStock = $storeItem ? $storeItem->stock_quantity : 0;
                                    if ($this->purchase && 
                                        $this->store_id == $this->purchase->getOriginal('store_id')) {
                                        $originalItem = $this->purchase->items()->where('item_id', $item_id)->first();
                                        if ($originalItem) {
                                            $baseStock -= $originalItem->quantity;
                                        }
                                    }
                                    $this->selected_items[$index]['stock'] = $baseStock;
                                }
                            }
                        } else {
                            $this->selected_items[$index]['cost'] = 0;
                            $this->selected_items[$index]['stock'] = 0;
                        }
                    }

                    $qty = floatval($this->selected_items[$index]['quantity'] ?? 0);
                    $cost = floatval($this->selected_items[$index]['cost'] ?? 0);
                    $this->selected_items[$index]['total'] = $qty * $cost;
                }

                $this->calculateTotals();
            }
        }
    }

    public function updatedTaxRate()
    {
        $this->calculateTotals();
    }

    public function updatedDiscountAmount()
    {
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->subtotal = 0;
        foreach ($this->selected_items as $row) {
            $this->subtotal += floatval($row['total']);
        }

        $this->tax_amount = ($this->subtotal * floatval($this->tax_rate)) / 100;
        $this->grand_total = ($this->subtotal + $this->tax_amount) - floatval($this->discount_amount);
    }

    public function save()
    {
        $this->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'store_id' => 'required|exists:stores,id',
            'purchase_no' => 'required|string|unique:purchases,purchase_no,' . ($this->purchaseId ?? 'NULL') . ',id',
            'purchase_date' => 'required|date',
            'payment_status' => 'required|in:paid,pending,partial',
            'selected_items' => 'required|array|min:1',
            'selected_items.*.item_id' => 'required|exists:items,id',
            'selected_items.*.quantity' => 'required|integer|min:1',
            'discount_amount' => 'required|numeric|min:0',
        ]);

        if ($this->purchaseId) {
            foreach ($this->purchase->items as $oldItem) {
                $oldStoreItem = StoreItem::where('store_id', $this->purchase->getOriginal('store_id'))
                    ->where('item_id', $oldItem->item_id)
                    ->first();
                $currentStock = $oldStoreItem ? $oldStoreItem->stock_quantity : 0;
                
                $newQty = 0;
                $storeChanged = ($this->store_id != $this->purchase->getOriginal('store_id'));
                if (!$storeChanged) {
                    foreach ($this->selected_items as $newRow) {
                        if ($newRow['item_id'] == $oldItem->item_id) {
                            $newQty += $newRow['quantity'];
                        }
                    }
                }
                
                $netStock = $currentStock - $oldItem->quantity + $newQty;
                if ($netStock < 0) {
                    $itemModel = Item::find($oldItem->item_id);
                    session()->flash('error', 'Cannot update purchase. Reverting/decreasing this purchase would result in negative stock (' . $netStock . ') for item: ' . ($itemModel ? $itemModel->name : 'item'));
                    return;
                }
            }
        }

        DB::transaction(function () {
            if ($this->purchaseId) {
                // Revert original stock increment
                foreach ($this->purchase->items as $oldItem) {
                    $oldStoreItem = StoreItem::where('store_id', $this->purchase->getOriginal('store_id'))
                        ->where('item_id', $oldItem->item_id)
                        ->first();
                    if ($oldStoreItem) {
                        $oldStoreItem->decrement('stock_quantity', $oldItem->quantity);
                    }
                    $oldGlobalItem = Item::find($oldItem->item_id);
                    if ($oldGlobalItem) {
                        $oldGlobalItem->decrement('stock_quantity', $oldItem->quantity);
                    }
                }
                $this->purchase->items()->delete();

                $this->purchase->update([
                    'supplier_id' => $this->supplier_id,
                    'store_id' => $this->store_id,
                    'purchase_no' => $this->purchase_no,
                    'purchase_date' => $this->purchase_date,
                    'tax_amount' => $this->tax_amount,
                    'discount_amount' => $this->discount_amount,
                    'grand_total' => $this->grand_total,
                    'payment_status' => $this->payment_status,
                    'remarks' => $this->remarks,
                ]);
                $purchase = $this->purchase;
            } else {
                $purchase = Purchase::create([
                    'supplier_id' => $this->supplier_id,
                    'store_id' => $this->store_id,
                    'purchase_no' => $this->purchase_no,
                    'purchase_date' => $this->purchase_date,
                    'tax_amount' => $this->tax_amount,
                    'discount_amount' => $this->discount_amount,
                    'grand_total' => $this->grand_total,
                    'payment_status' => $this->payment_status,
                    'remarks' => $this->remarks,
                ]);
            }

            foreach ($this->selected_items as $row) {
                $purchase->items()->create([
                    'item_id' => $row['item_id'],
                    'quantity' => $row['quantity'],
                    'cost_price' => $row['cost'],
                    'total' => $row['total'],
                ]);

                $storeItem = StoreItem::firstOrCreate([
                    'store_id' => $this->store_id,
                    'item_id' => $row['item_id']
                ]);
                $storeItem->increment('stock_quantity', $row['quantity']);

                $item = Item::find($row['item_id']);
                if ($item) {
                    $item->increment('stock_quantity', $row['quantity']);
                }
            }

            if ($this->purchaseId) {
                ActivityLog::log('Update Purchase', 'Purchase No: ' . $purchase->purchase_no . ' updated. Total: $' . $purchase->grand_total);
            } else {
                ActivityLog::log('Create Purchase', 'Purchase No: ' . $purchase->purchase_no . ' recorded. Total: $' . $purchase->grand_total);
            }

            if (auth()->check()) {
                auth()->user()->notify(new \App\Notifications\SystemNotification(
                    $this->purchaseId ? 'Purchase Updated' : 'Purchase Recorded',
                    'Purchase Invoice ' . $purchase->purchase_no . ($this->purchaseId ? ' updated' : ' recorded') . ' successfully. Total: $' . $purchase->grand_total,
                    'success',
                    'fa-solid fa-bag-shopping'
                ));
            }
        });

        session()->flash('message', $this->purchaseId ? 'Purchase Invoice Updated Successfully.' : 'Purchase Invoice Recorded Successfully.');
        session()->flash('alert-type', 'success');

        return $this->redirectRoute('purchases.list');
    }

    public function render()
    {
        return view('livewire.purchases.form', [
            'suppliers' => Supplier::where('status', true)->get(),
            'stores' => Store::where('status', true)->get(),
            'items' => Item::where('status', true)->get(),
        ]);
    }
}
