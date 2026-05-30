<?php

namespace App\Livewire\Settings;

use App\Models\Department;
use App\Livewire\DataTable;

class DepartmentsTable extends DataTable
{
    protected string $model = Department::class;

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
            'label' => 'Description',
            'field' => 'description',
            'width' => 'w-auto',
            'searchable' => true,
            'orderable' => false,
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
            'label' => 'Date Created',
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
        'create' => 'settings.departments.create',
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

    public function actions($department)
    {
        return view('components.settings.departments-actions', compact('department'));
    }

    public function delete($id): void
    {
        Department::findOrFail($id)->delete();
        session()->flash('message', 'Department deleted successfully.');
        session()->flash('alert-type', 'success');
        $this->resetPage();
    }
}
