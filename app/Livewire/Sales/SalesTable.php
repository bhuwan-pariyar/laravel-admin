<?php

namespace App\Livewire\Sales;

use App\Models\Sale;
use App\Models\StoreItem;
use App\Models\Item;
use App\Models\ActivityLog;
use App\Livewire\DataTable;
use Illuminate\Support\Facades\DB;

class SalesTable extends DataTable
{
    protected string $model = Sale::class;

    protected array $columns = [
        [
            'label' => 'ID',
            'field' => 'id',
            'width' => 'w-20',
            'searchable' => false,
            'orderable' => true,
        ],
        [
            'label' => 'Invoice No',
            'field' => 'invoice_no',
            'width' => 'w-auto',
            'searchable' => true,
            'orderable' => true,
        ],
        [
            'label' => 'Customer',
            'field' => 'customer_id',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'customerName',
            'orderable' => false,
        ],
        [
            'label' => 'Store',
            'field' => 'store_id',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'storeName',
            'orderable' => false,
        ],
        [
            'label' => 'Sale Date',
            'field' => 'sale_date',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'formatDate',
            'orderable' => true,
        ],
        [
            'label' => 'Grand Total',
            'field' => 'grand_total',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'formatPrice',
            'orderable' => true,
        ],
        [
            'label' => 'Payment',
            'field' => 'payment_status',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'paymentBadge',
            'orderable' => true,
        ],
    ];

    protected array $filters = [
        'payment_status' => [
            'type' => 'select',
            'label' => 'Payment Status',
            'options' => [
                'paid' => 'Paid',
                'pending' => 'Pending',
                'partial' => 'Partial',
            ],
        ],
    ];

    protected array $executions = [
        'create' => 'sales.create',
    ];

    protected function customerName($row)
    {
        return '<span class="font-medium text-slate-800">' . e($row->customer->name) . '</span>';
    }

    protected function storeName($row)
    {
        return '<span class="text-slate-600">' . e($row->store->name) . '</span>';
    }

    protected function formatDate($row)
    {
        return $row->sale_date ? $row->sale_date->format('Y-m-d') : '';
    }

    protected function formatPrice($row)
    {
        return '<span class="font-bold text-slate-900">$' . number_format($row->grand_total, 2) . '</span>';
    }

    protected function paymentBadge($row)
    {
        $status = strtolower($row->payment_status);

        $colors = [
            'paid' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400',
            'pending' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-400',
            'partial' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400',
        ];

        return '<span class="px-2.5 py-0.5 text-xs font-semibold rounded-full ' . ($colors[$status] ?? 'bg-slate-100') . '">' . ucfirst($status) . '</span>';
    }

    public function actions($sale)
    {
        return '<div class="flex gap-2 items-center justify-center">
            <a href="' . route('sales.show', $sale->id) . '" class="text-green-600 hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </a>
            <a href="' . route('sales.edit', $sale->id) . '" class="text-blue-600 hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </a>
            <button wire:click="delete(' . $sale->id . ')" wire:confirm="Are you sure you want to delete this sale and restore stock?" class="text-red-600 hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </div>';
    }

    public function delete($id): void
    {
        $sale = Sale::findOrFail($id);
        DB::transaction(function () use ($sale) {
            foreach ($sale->items as $item) {
                // Restore store stock
                $storeItem = StoreItem::where('store_id', $sale->store_id)
                    ->where('item_id', $item->item_id)
                    ->first();
                if ($storeItem) {
                    $storeItem->increment('stock_quantity', $item->quantity);
                }

                // Restore global stock
                $globalItem = Item::find($item->item_id);
                if ($globalItem) {
                    $globalItem->increment('stock_quantity', $item->quantity);
                }
            }

            // Log activity
            ActivityLog::log('Delete Sale', 'Sale ID: ' . $sale->id . ', Invoice No: ' . $sale->invoice_no . ' deleted. Stock restored.');

            // Delete associated items and the sale
            $sale->items()->delete();
            $sale->delete();
        });

        session()->flash('message', 'Invoice deleted and stock restored successfully.');
        session()->flash('alert-type', 'success');
        $this->resetPage();
    }
}
