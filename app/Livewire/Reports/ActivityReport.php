<?php

namespace App\Livewire\Reports;

use App\Models\ActivityLog;
use App\Livewire\DataTable;

class ActivityReport extends DataTable
{
    protected string $model = ActivityLog::class;

    protected array $columns = [
        [
            'label' => 'ID',
            'field' => 'id',
            'width' => 'w-20',
            'searchable' => false,
            'orderable' => true,
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
            'label' => 'Action',
            'field' => 'action',
            'width' => 'w-auto',
            'searchable' => true,
            'orderable' => true,
        ],
        [
            'label' => 'Description',
            'field' => 'description',
            'width' => 'w-auto',
            'searchable' => true,
            'orderable' => false,
        ],
        [
            'label' => 'IP Address',
            'field' => 'ip_address',
            'width' => 'w-auto',
            'searchable' => true,
            'orderable' => true,
        ],
        [
            'label' => 'Timestamp',
            'field' => 'created_at',
            'width' => 'w-auto',
            'searchable' => false,
            'orderable' => true,
        ],
    ];

    protected function userName($row)
    {
        return $row->user ? '<span class="font-medium text-slate-800">' . e($row->user->name) . '</span>' : '<span class="text-slate-400">System</span>';
    }
}
