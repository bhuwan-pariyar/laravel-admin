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

    public function mount()
    {
        $this->purchase_no = 'PUR-' . strtoupper(uniqid());
        $this->purchase_date = date('Y-m-d');
        $this->addItemRow();
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
                $this->selected_items[$index]['stock'] = $storeItem ? $storeItem->stock_quantity : 0;
            }
        }
        $this->calculateTotals();
    }

    public function updatedSelectedItems($value, $key)
    {
        $parts = explode('.', $key);
        if (count($parts) === 2) {
            $index = $parts[0];
            $field = $parts[1];

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
                            $this->selected_items[$index]['stock'] = $storeItem ? $storeItem->stock_quantity : 0;
                        }
                    }
                } else {
                    $this->selected_items[$index]['cost'] = 0;
                    $this->selected_items[$index]['stock'] = 0;
                }
            }

            // Calculate total for this row
            $qty = floatval($this->selected_items[$index]['quantity'] ?? 0);
            $cost = floatval($this->selected_items[$index]['cost'] ?? 0);
            $this->selected_items[$index]['total'] = $qty * $cost;
        }

        $this->calculateTotals();
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
            'purchase_no' => 'required|string|unique:purchases,purchase_no',
            'purchase_date' => 'required|date',
            'payment_status' => 'required|in:paid,pending,partial',
            'selected_items' => 'required|array|min:1',
            'selected_items.*.item_id' => 'required|exists:items,id',
            'selected_items.*.quantity' => 'required|integer|min:1',
            'discount_amount' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () {
            // Create Purchase record
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

            // Save items and adjust stock levels
            foreach ($this->selected_items as $row) {
                $purchase->items()->create([
                    'item_id' => $row['item_id'],
                    'quantity' => $row['quantity'],
                    'cost_price' => $row['cost'],
                    'total' => $row['total'],
                ]);

                // Increment store stock
                $storeItem = StoreItem::firstOrCreate([
                    'store_id' => $this->store_id,
                    'item_id' => $row['item_id']
                ]);
                $storeItem->increment('stock_quantity', $row['quantity']);

                // Increment global item stock
                $item = Item::find($row['item_id']);
                if ($item) {
                    $item->increment('stock_quantity', $row['quantity']);
                }
            }

            // Log activity
            ActivityLog::log('Create Purchase', 'Purchase No: ' . $purchase->purchase_no . ' recorded. Total: $' . $purchase->grand_total);
        });

        session()->flash('message', 'Purchase Invoice Recorded Successfully.');
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
