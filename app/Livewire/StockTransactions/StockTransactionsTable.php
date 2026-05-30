<?php

namespace App\Livewire\StockTransactions;

use App\Models\StockTransaction;
use App\Livewire\DataTable;

class StockTransactionsTable extends DataTable
{
    protected string $model = StockTransaction::class;

    protected array $columns = [
        [
            'label' => 'ID',
            'field' => 'id',
            'width' => 'w-20',
            'searchable' => false,
            'orderable' => true,
        ],
        [
            'label' => 'Item SKU',
            'field' => 'item_sku',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'itemSku',
            'orderable' => false,
        ],
        [
            'label' => 'Item Name',
            'field' => 'item_name',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'itemName',
            'orderable' => false,
        ],
        [
            'label' => 'User',
            'field' => 'user_id',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'userName',
            'orderable' => false,
        ],
        [
            'label' => 'Type',
            'field' => 'type',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'typeBadge',
            'orderable' => true,
        ],
        [
            'label' => 'Quantity',
            'field' => 'quantity',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'quantityFormatted',
            'orderable' => true,
        ],
        [
            'label' => 'Remarks',
            'field' => 'remarks',
            'width' => 'w-auto',
            'searchable' => true,
            'orderable' => false,
        ],
        [
            'label' => 'Date',
            'field' => 'created_at',
            'width' => 'w-auto',
            'searchable' => false,
            'orderable' => true,
        ],
    ];

    protected array $filters = [
        'type' => [
            'type' => 'select',
            'label' => 'Type',
            'options' => [
                'in' => 'Inward (Add)',
                'out' => 'Outward (Remove)',
                'purchase' => 'Purchase (Buy)',
                'sale' => 'Sale (Sell)',
                'adjustment' => 'Adjustment',
            ],
        ],
    ];

    protected array $executions = [
        'create' => 'transactions.create',
    ];

    protected function itemSku($row)
    {
        return $row->item ? '<span class="text-sm font-semibold text-slate-700">' . e($row->item->sku) . '</span>' : 'N/A';
    }

    protected function itemName($row)
    {
        return $row->item ? '<span class="text-sm text-slate-900">' . e($row->item->name) . '</span>' : 'N/A';
    }

    protected function userName($row)
    {
        return $row->user ? '<span class="text-sm text-slate-600">' . e($row->user->name) . '</span>' : 'N/A';
    }

    protected function typeBadge($row)
    {
        $colors = [
            'in' => 'bg-green-100 text-green-800',
            'out' => 'bg-red-100 text-red-800',
            'purchase' => 'bg-emerald-100 text-emerald-800',
            'sale' => 'bg-indigo-100 text-indigo-800',
            'adjustment' => 'bg-blue-100 text-blue-800',
        ];

        $labels = [
            'in' => 'Stock In',
            'out' => 'Stock Out',
            'purchase' => 'Purchase',
            'sale' => 'Sale',
            'adjustment' => 'Adjustment',
        ];

        return '<span class="px-2.5 py-0.5 text-xs font-semibold rounded-full ' . ($colors[$row->type] ?? 'bg-slate-100') . '">' . ($labels[$row->type] ?? ucfirst($row->type)) . '</span>';
    }

    protected function quantityFormatted($row)
    {
        $isAdd = in_array($row->type, ['in', 'purchase']) || ($row->type === 'adjustment' && $row->quantity >= 0);
        $prefix = $isAdd ? '+' : '-';
        $color = in_array($row->type, ['in', 'purchase']) ? 'text-green-600' : (in_array($row->type, ['out', 'sale']) ? 'text-red-600' : 'text-blue-600');

        return '<span class="' . $color . ' font-bold">' . $prefix . abs($row->quantity) . '</span>';
    }
}
