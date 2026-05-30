<?php

namespace App\Livewire\Transfers;

use App\Models\Transfer;
use App\Livewire\DataTable;

class TransfersTable extends DataTable
{
    protected string $model = Transfer::class;

    protected array $columns = [
        [
            'label' => 'ID',
            'field' => 'id',
            'width' => 'w-20',
            'searchable' => false,
            'orderable' => true,
        ],
        [
            'label' => 'Transfer No',
            'field' => 'transfer_no',
            'width' => 'w-auto',
            'searchable' => true,
            'orderable' => true,
        ],
        [
            'label' => 'From Store',
            'field' => 'from_store_id',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'fromStoreName',
            'orderable' => false,
        ],
        [
            'label' => 'To Store',
            'field' => 'to_store_id',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'toStoreName',
            'orderable' => false,
        ],
        [
            'label' => 'Transfer Date',
            'field' => 'transfer_date',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'formatDate',
            'orderable' => true,
        ],
        [
            'label' => 'Status',
            'field' => 'status',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'statusBadge',
            'orderable' => true,
        ],
    ];

    protected array $filters = [
        'status' => [
            'type' => 'select',
            'label' => 'Status',
            'options' => [
                'pending' => 'Pending',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled',
            ],
        ],
    ];

    protected array $executions = [
        'create' => 'transfers.create',
    ];

    protected function fromStoreName($row)
    {
        return '<span class="text-slate-700">' . e($row->fromStore->name) . '</span>';
    }

    protected function toStoreName($row)
    {
        return '<span class="text-slate-700">' . e($row->toStore->name) . '</span>';
    }

    protected function formatDate($row)
    {
        return $row->transfer_date ? $row->transfer_date->format('Y-m-d') : '';
    }

    protected function statusBadge($row)
    {
        $status = strtolower($row->status);

        $colors = [
            'completed' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400',
            'pending' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400',
            'cancelled' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-400',
        ];

        return '<span class="px-2.5 py-0.5 text-xs font-semibold rounded-full ' . ($colors[$status] ?? 'bg-slate-100') . '">' . ucfirst($status) . '</span>';
    }

    public function actions($transfer)
    {
        return '<div class="flex gap-2 items-center justify-center">
            <a href="' . route('transfers.show', $transfer->id) . '" class="text-green-600 hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </a>
        </div>';
    }
}
