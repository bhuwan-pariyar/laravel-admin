<?php

namespace App\Livewire\Suppliers;

use App\Models\Supplier;
use App\Livewire\DataTable;

class SuppliersTable extends DataTable
{
    protected string $model = Supplier::class;

    protected $listeners = ['supplierCreated' => 'resetPage'];

    protected array $columns = [
        [
            'label' => 'ID',
            'field' => 'id',
            'width' => 'w-20',
            'searchable' => false,
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
            'label' => 'Email',
            'field' => 'email',
            'width' => 'w-auto',
            'searchable' => true,
            'orderable' => true,
        ],
        [
            'label' => 'Phone',
            'field' => 'phone',
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
        'create' => 'suppliers.create',
    ];

    protected function statusBadge($row)
    {
        $status = $row->status ? 'active' : 'inactive';

        $colors = [
            'active' => 'bg-green-100 text-green-800',
            'inactive' => 'bg-slate-100 text-slate-800',
        ];

        return '<span class="px-2.5 py-0.5 text-xs font-semibold rounded-full ' . $colors[$status] . '">' . ucfirst($status) . '</span>';
    }

    public function actions($supplier)
    {
        return view('components.suppliers.suppliers-actions', compact('supplier'));
    }

    public function delete($id): void
    {
        Supplier::findOrFail($id)->delete();
        session()->flash('success', 'Supplier deleted successfully.');
        $this->resetPage();
    }
}
