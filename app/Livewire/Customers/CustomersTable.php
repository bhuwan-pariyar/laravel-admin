<?php

namespace App\Livewire\Customers;

use App\Models\Customer;
use App\Livewire\DataTable;

class CustomersTable extends DataTable
{
    protected string $model = Customer::class;

    protected $listeners = ['customerCreated' => 'resetPage'];

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
        'create' => 'customers.create',
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

    public function actions($customer)
    {
        return view('components.customers.customers-actions', compact('customer'));
    }

    public function delete($id): void
    {
        Customer::findOrFail($id)->delete();
        session()->flash('success', 'Customer deleted successfully.');
        $this->resetPage();
    }
}
