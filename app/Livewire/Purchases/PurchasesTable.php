<?php

namespace App\Livewire\Purchases;

use App\Models\Purchase;
use App\Livewire\DataTable;

class PurchasesTable extends DataTable
{
    protected string $model = Purchase::class;

    protected array $columns = [
        [
            'label' => 'ID',
            'field' => 'id',
            'width' => 'w-20',
            'searchable' => false,
            'orderable' => true,
        ],
        [
            'label' => 'Purchase No',
            'field' => 'purchase_no',
            'width' => 'w-auto',
            'searchable' => true,
            'orderable' => true,
        ],
        [
            'label' => 'Supplier',
            'field' => 'supplier_id',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'supplierName',
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
            'label' => 'Purchase Date',
            'field' => 'purchase_date',
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
        'create' => 'purchases.create',
    ];

    protected function supplierName($row)
    {
        return '<span class="font-medium text-slate-800">' . e($row->supplier->name) . '</span>';
    }

    protected function storeName($row)
    {
        return '<span class="text-slate-600">' . e($row->store->name) . '</span>';
    }

    protected function formatDate($row)
    {
        return $row->purchase_date ? $row->purchase_date->format('Y-m-d') : '';
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

    public function actions($purchase)
    {
        return '<div class="flex gap-2 items-center justify-center">
            <a href="' . route('purchases.show', $purchase->id) . '" class="text-green-600 hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </a>
        </div>';
    }
}
