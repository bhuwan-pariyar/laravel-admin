<?php

namespace App\Livewire\Sales;

use App\Models\Sale;
use App\Models\Customer;
use App\Models\Store;
use App\Models\Item;
use App\Models\StoreItem;
use App\Models\ActivityLog;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Form extends Component
{
    public $customer_id = '';
    public $store_id = '';
    public $invoice_no = '';
    public $sale_date = '';
    public $payment_status = 'pending';
    public $remarks = '';

    public $selected_items = []; // Array of arrays: ['item_id' => ..., 'quantity' => ..., 'price' => ..., 'stock' => ...]
    public $tax_rate = 0; // percentage
    public $discount_amount = 0;

    public $subtotal = 0;
    public $tax_amount = 0;
    public $grand_total = 0;

    public function mount()
    {
        $this->invoice_no = 'INV-' . strtoupper(uniqid());
        $this->sale_date = date('Y-m-d');
        // Add one initial empty item row
        $this->addItemRow();
    }

    public function addItemRow()
    {
        $this->selected_items[] = [
            'item_id' => '',
            'quantity' => 1,
            'price' => 0,
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
        // $key format: index.field, e.g. "0.item_id" or "0.quantity"
        $parts = explode('.', $key);
        if (count($parts) === 2) {
            $index = $parts[0];
            $field = $parts[1];

            if ($field === 'item_id') {
                $item_id = $value;
                if ($item_id) {
                    $item = Item::find($item_id);
                    if ($item) {
                        $this->selected_items[$index]['price'] = $item->selling_price;
                        
                        if ($this->store_id) {
                            $storeItem = StoreItem::where('store_id', $this->store_id)
                                ->where('item_id', $item_id)
                                ->first();
                            $this->selected_items[$index]['stock'] = $storeItem ? $storeItem->stock_quantity : 0;
                        }
                    }
                } else {
                    $this->selected_items[$index]['price'] = 0;
                    $this->selected_items[$index]['stock'] = 0;
                }
            }

            // Calculate total for this row
            $qty = floatval($this->selected_items[$index]['quantity'] ?? 0);
            $price = floatval($this->selected_items[$index]['price'] ?? 0);
            $this->selected_items[$index]['total'] = $qty * $price;
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
            'customer_id' => 'required|exists:customers,id',
            'store_id' => 'required|exists:stores,id',
            'invoice_no' => 'required|string|unique:sales,invoice_no',
            'sale_date' => 'required|date',
            'payment_status' => 'required|in:paid,pending,partial',
            'selected_items' => 'required|array|min:1',
            'selected_items.*.item_id' => 'required|exists:items,id',
            'selected_items.*.quantity' => 'required|integer|min:1',
            'discount_amount' => 'required|numeric|min:0',
        ]);

        // Verify stock availability
        foreach ($this->selected_items as $row) {
            $storeItem = StoreItem::where('store_id', $this->store_id)
                ->where('item_id', $row['item_id'])
                ->first();
            $available = $storeItem ? $storeItem->stock_quantity : 0;

            if ($row['quantity'] > $available) {
                $item = Item::find($row['item_id']);
                session()->flash('error', 'Insufficient stock for ' . ($item ? $item->name : 'item') . '. Available: ' . $available);
                return;
            }
        }

        DB::transaction(function () {
            // Create Sale record
            $sale = Sale::create([
                'customer_id' => $this->customer_id,
                'store_id' => $this->store_id,
                'invoice_no' => $this->invoice_no,
                'sale_date' => $this->sale_date,
                'tax_amount' => $this->tax_amount,
                'discount_amount' => $this->discount_amount,
                'grand_total' => $this->grand_total,
                'payment_status' => $this->payment_status,
                'remarks' => $this->remarks,
            ]);

            // Save items and adjust stock levels
            foreach ($this->selected_items as $row) {
                $sale->items()->create([
                    'item_id' => $row['item_id'],
                    'quantity' => $row['quantity'],
                    'selling_price' => $row['price'],
                    'total' => $row['total'],
                ]);

                // Deduct from store stock
                $storeItem = StoreItem::where('store_id', $this->store_id)
                    ->where('item_id', $row['item_id'])
                    ->first();
                if ($storeItem) {
                    $storeItem->decrement('stock_quantity', $row['quantity']);
                }

                // Adjust global item stock
                $item = Item::find($row['item_id']);
                if ($item) {
                    $item->decrement('stock_quantity', $row['quantity']);

                    if ($item->isLowStock()) {
                        if (auth()->check()) {
                            auth()->user()->notify(new \App\Notifications\SystemNotification(
                                'Low Stock Alert',
                                "Item '{$item->name}' is running low on stock ({$item->stock_quantity} left).",
                                'warning',
                                'fa-solid fa-triangle-exclamation'
                            ));
                        }
                    }
                }
            }

            // Log activity
            ActivityLog::log('Create Sale', 'Invoice No: ' . $sale->invoice_no . ' created. Total: $' . $sale->grand_total);

            // Trigger notification
            if (auth()->check()) {
                auth()->user()->notify(new \App\Notifications\SystemNotification(
                    'Sale Completed',
                    'Invoice No: ' . $sale->invoice_no . ' created successfully. Total: $' . $sale->grand_total,
                    'success',
                    'fa-solid fa-cart-shopping'
                ));
            }
        });

        session()->flash('message', 'Invoice Created Successfully.');
        session()->flash('alert-type', 'success');

        return $this->redirectRoute('sales.list');
    }

    public function render()
    {
        return view('livewire.sales.form', [
            'customers' => Customer::where('status', true)->get(),
            'stores' => Store::where('status', true)->get(),
            'items' => Item::where('status', true)->get(),
        ]);
    }
}
