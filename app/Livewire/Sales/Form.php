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
    public ?int $saleId = null;
    public ?Sale $sale = null;

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

    public function mount(?int $saleId = null)
    {
        if ($saleId) {
            $this->sale = Sale::findOrFail($saleId);
            $this->saleId = $this->sale->id;
            $this->customer_id = $this->sale->customer_id;
            $this->store_id = $this->sale->store_id;
            $this->invoice_no = $this->sale->invoice_no;
            $this->sale_date = $this->sale->sale_date ? $this->sale->sale_date->format('Y-m-d') : '';
            $this->payment_status = $this->sale->payment_status;
            $this->remarks = $this->sale->remarks;
            $this->discount_amount = $this->sale->discount_amount;
            
            // Reconstruct tax rate and load selected items
            $this->selected_items = [];
            foreach ($this->sale->items as $item) {
                $storeItem = StoreItem::where('store_id', $this->store_id)
                    ->where('item_id', $item->item_id)
                    ->first();
                $baseStock = $storeItem ? $storeItem->stock_quantity : 0;
                $this->selected_items[] = [
                    'item_id' => $item->item_id,
                    'quantity' => $item->quantity,
                    'price' => $item->selling_price,
                    'stock' => $baseStock + $item->quantity,
                    'total' => $item->total,
                ];
            }
            $subtotal = 0;
            foreach ($this->selected_items as $row) {
                $subtotal += floatval($row['total']);
            }
            if ($subtotal > 0) {
                $this->tax_rate = round(($this->sale->tax_amount * 100) / $subtotal, 2);
            } else {
                $this->tax_rate = 0;
            }
            $this->calculateTotals();
        } else {
            $this->invoice_no = 'INV-' . strtoupper(uniqid());
            $this->sale_date = date('Y-m-d');
            $this->addItemRow();
        }
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
                $baseStock = $storeItem ? $storeItem->stock_quantity : 0;
                if ($this->sale && 
                    $this->store_id == $this->sale->getOriginal('store_id')) {
                    $originalItem = $this->sale->items()->where('item_id', $row['item_id'])->first();
                    if ($originalItem) {
                        $baseStock += $originalItem->quantity;
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
                                $this->selected_items[$index]['price'] = $item->selling_price;
                                
                                if ($this->store_id) {
                                    $storeItem = StoreItem::where('store_id', $this->store_id)
                                        ->where('item_id', $item_id)
                                        ->first();
                                    $baseStock = $storeItem ? $storeItem->stock_quantity : 0;
                                    if ($this->sale && 
                                        $this->store_id == $this->sale->getOriginal('store_id')) {
                                        $originalItem = $this->sale->items()->where('item_id', $item_id)->first();
                                        if ($originalItem) {
                                            $baseStock += $originalItem->quantity;
                                        }
                                    }
                                    $this->selected_items[$index]['stock'] = $baseStock;
                                }
                            }
                        } else {
                            $this->selected_items[$index]['price'] = 0;
                            $this->selected_items[$index]['stock'] = 0;
                        }
                    }

                    $qty = floatval($this->selected_items[$index]['quantity'] ?? 0);
                    $price = floatval($this->selected_items[$index]['price'] ?? 0);
                    $this->selected_items[$index]['total'] = $qty * $price;
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
            'customer_id' => 'required|exists:customers,id',
            'store_id' => 'required|exists:stores,id',
            'invoice_no' => 'required|string|unique:sales,invoice_no,' . ($this->saleId ?? 'NULL') . ',id',
            'sale_date' => 'required|date',
            'payment_status' => 'required|in:paid,pending,partial',
            'selected_items' => 'required|array|min:1',
            'selected_items.*.item_id' => 'required|exists:items,id',
            'selected_items.*.quantity' => 'required|integer|min:1',
            'discount_amount' => 'required|numeric|min:0',
        ]);

        // Verify stock availability
        foreach ($this->selected_items as $row) {
            if ($row['quantity'] > $row['stock']) {
                $item = Item::find($row['item_id']);
                session()->flash('error', 'Insufficient stock for ' . ($item ? $item->name : 'item') . '. Available: ' . $row['stock']);
                return;
            }
        }

        DB::transaction(function () {
            if ($this->saleId) {
                // Revert original stock
                foreach ($this->sale->items as $oldItem) {
                    $oldStoreItem = StoreItem::where('store_id', $this->sale->getOriginal('store_id'))
                        ->where('item_id', $oldItem->item_id)
                        ->first();
                    if ($oldStoreItem) {
                        $oldStoreItem->increment('stock_quantity', $oldItem->quantity);
                    }
                    $oldGlobalItem = Item::find($oldItem->item_id);
                    if ($oldGlobalItem) {
                        $oldGlobalItem->increment('stock_quantity', $oldItem->quantity);
                    }
                }
                $this->sale->items()->delete();

                $this->sale->update([
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
                $sale = $this->sale;
            } else {
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
            }

            foreach ($this->selected_items as $row) {
                $sale->items()->create([
                    'item_id' => $row['item_id'],
                    'quantity' => $row['quantity'],
                    'selling_price' => $row['price'],
                    'total' => $row['total'],
                ]);

                $storeItem = StoreItem::firstOrCreate([
                    'store_id' => $this->store_id,
                    'item_id' => $row['item_id']
                ]);
                $storeItem->decrement('stock_quantity', $row['quantity']);

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

            if ($this->saleId) {
                ActivityLog::log('Update Sale', 'Invoice No: ' . $sale->invoice_no . ' updated. Total: $' . $sale->grand_total);
            } else {
                ActivityLog::log('Create Sale', 'Invoice No: ' . $sale->invoice_no . ' created. Total: $' . $sale->grand_total);
            }

            if (auth()->check()) {
                auth()->user()->notify(new \App\Notifications\SystemNotification(
                    $this->saleId ? 'Sale Updated' : 'Sale Completed',
                    'Invoice No: ' . $sale->invoice_no . ($this->saleId ? ' updated' : ' created') . ' successfully. Total: $' . $sale->grand_total,
                    'success',
                    'fa-solid fa-cart-shopping'
                ));
            }
        });

        session()->flash('message', $this->saleId ? 'Invoice Updated Successfully.' : 'Invoice Created Successfully.');
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
