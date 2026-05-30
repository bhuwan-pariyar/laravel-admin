<?php

namespace App\Livewire\StockTransactions;

use App\Models\Item;
use App\Models\StockTransaction;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Form extends Component
{
    public $item_id = '';
    public $type = 'in';
    public $quantity = 1;
    public $remarks = '';

    protected function rules()
    {
        return [
            'item_id' => 'required|exists:items,id',
            'type' => 'required|in:in,out,adjustment,purchase,sale',
            'quantity' => 'required|integer|min:1',
            'remarks' => 'nullable|string|max:500',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        $item = Item::findOrFail($this->item_id);

        if (($this->type === 'out' || $this->type === 'sale') && $item->stock_quantity < $this->quantity) {
            $this->addError('quantity', 'The quantity to remove exceeds the available stock (' . $item->stock_quantity . ').');
            return;
        }

        DB::transaction(function () use ($validated, $item) {
            // Log transaction
            StockTransaction::create([
                'item_id' => $this->item_id,
                'user_id' => Auth::id(),
                'type' => $this->type,
                'quantity' => ($this->type === 'out' || $this->type === 'sale') ? -$this->quantity : $this->quantity,
                'remarks' => $this->remarks,
            ]);

            // Update item stock
            if ($this->type === 'in' || $this->type === 'purchase') {
                $item->increment('stock_quantity', $this->quantity);
            } elseif ($this->type === 'out' || $this->type === 'sale') {
                $item->decrement('stock_quantity', $this->quantity);
            } elseif ($this->type === 'adjustment') {
                $item->increment('stock_quantity', $this->quantity);
            }
        });

        session()->flash('message', 'Stock Transaction logged successfully.');
        session()->flash('alert-type', 'success');

        return $this->redirectRoute('transactions.list');
    }

    public function render()
    {
        $items = Item::where('status', true)->get();

        return view('livewire.stock-transactions.form', [
            'items' => $items,
        ]);
    }
}
