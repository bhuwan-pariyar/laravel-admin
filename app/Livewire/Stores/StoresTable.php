<?php

namespace App\Livewire\Stores;

use App\Models\Store;
use App\Livewire\DataTable;

class StoresTable extends DataTable
{
    protected string $model = Store::class;

    protected $listeners = ['storeCreated' => 'resetPage'];

    protected array $columns = [
        [
            'label' => 'ID',
            'field' => 'id',
            'width' => 'w-20',
            'searchable' => false,
            'orderable' => true,
        ],
        [
            'label' => 'Code',
            'field' => 'code',
            'width' => 'w-auto',
            'searchable' => true,
            'orderable' => true,
        ],
        [
            'label' => 'Name',
            'field' => 'name',
            'width' => 'w-auto',
            'searchable' => true,
            'orderable' => true,
        ],
        [
            'label' => 'Location',
            'field' => 'location',
            'width' => 'w-auto',
            'searchable' => true,
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
        [
            'label' => 'Date',
            'field' => 'created_at',
            'width' => 'w-auto',
            'searchable' => false,
            'orderable' => true,
        ],
    ];

    protected array $filters = [
        'status' => [
            'type' => 'select',
            'label' => 'Status',
            'options' => [
                '1' => 'Active',
                '0' => 'Inactive',
            ],
        ],
    ];

    protected array $executions = [
        'create' => 'stores.create',
    ];

    protected function statusBadge($row)
    {
        $status = $row->status ? 'active' : 'inactive';

        $colors = [
            'active' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400',
            'inactive' => 'bg-slate-100 text-slate-800 dark:bg-slate-800/40 dark:text-slate-400',
        ];

        return '<span class="px-2.5 py-0.5 text-xs font-semibold rounded-full ' . $colors[$status] . '">' . ucfirst($status) . '</span>';
    }

    public function actions($store)
    {
        return view('components.stores.stores-actions', compact('store'));
    }

    public function delete($id): void
    {
        Store::findOrFail($id)->delete();
        session()->flash('success', 'Store deleted successfully.');
        $this->resetPage();
    }
}
