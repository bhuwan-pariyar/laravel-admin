<?php

namespace App\Livewire\Roles;

use Spatie\Permission\Models\Role;
use App\Livewire\DataTable;

class RolesTable extends DataTable
{
    protected string $model = Role::class;

    protected array $columns = [
        [
            'label' => 'ID',
            'field' => 'id',
            'width' => 'w-20',
            'searchable' => false,
            'orderable' => true,
        ],
        [
            'label' => 'Role Name',
            'field' => 'name',
            'width' => 'w-auto',
            'searchable' => true,
            'orderable' => true,
        ],
        [
            'label' => 'Permissions',
            'field' => 'permissions_count',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'permissionsCount',
            'orderable' => false,
        ],
        [
            'label' => 'Guard',
            'field' => 'guard_name',
            'width' => 'w-auto',
            'searchable' => true,
            'orderable' => true,
        ],
        [
            'label' => 'Created At',
            'field' => 'created_at',
            'width' => 'w-auto',
            'searchable' => false,
            'orderable' => true,
        ],
    ];

    protected array $executions = [
        'create' => 'roles.create',
    ];

    protected function permissionsCount($row)
    {
        $count = $row->permissions()->count();
        return '<span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-slate-100 text-slate-800">' . $count . ' permissions</span>';
    }

    public function actions($role)
    {
        return view('components.roles.roles-actions', compact('role'));
    }

    public function delete($id): void
    {
        $role = Role::findOrFail($id);
        if ($role->name === 'Admin') {
            session()->flash('error', 'Cannot delete Admin role.');
            return;
        }
        $role->delete();
        session()->flash('success', 'Role deleted successfully.');
        $this->resetPage();
    }
}
