<?php

namespace App\Livewire\Damage;

use App\Models\DamageReport;
use App\Livewire\DataTable;

class DamageTable extends DataTable
{
    protected string $model = DamageReport::class;

    protected array $columns = [
        [
            'label' => 'ID',
            'field' => 'id',
            'width' => 'w-20',
            'searchable' => false,
            'orderable' => true,
        ],
        [
            'label' => 'Item',
            'field' => 'item_id',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'itemName',
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
            'label' => 'Quantity',
            'field' => 'quantity',
            'width' => 'w-auto',
            'searchable' => false,
            'orderable' => true,
        ],
        [
            'label' => 'Reported By',
            'field' => 'reported_by',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'reporterName',
            'orderable' => false,
        ],
        [
            'label' => 'Reported Date',
            'field' => 'reported_at',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'formatDate',
            'orderable' => true,
        ],
        [
            'label' => 'Remarks',
            'field' => 'remarks',
            'width' => 'w-auto',
            'searchable' => true,
            'orderable' => false,
        ],
    ];

    protected array $executions = [
        'create' => 'damage.create',
    ];

    protected function itemName($row)
    {
        return '<span class="font-medium text-slate-800">' . e($row->item->name) . '</span>';
    }

    protected function storeName($row)
    {
        return '<span class="text-slate-600">' . e($row->store->name) . '</span>';
    }

    protected function reporterName($row)
    {
        return '<span class="text-xs text-slate-600">' . e($row->reporter->name) . '</span>';
    }

    protected function formatDate($row)
    {
        return $row->reported_at ? $row->reported_at->format('Y-m-d H:i') : '';
    }
}
