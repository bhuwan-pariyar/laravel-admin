<?php

namespace App\Livewire\Roles;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\Component;

class Form extends Component
{
    public ?int $roleId = null;
    public ?Role $role = null;

    public $name = '';
    public array $selectedPermissions = [];

    public function mount(?int $roleId = null)
    {
        if ($roleId) {
            $this->role = Role::findOrFail($roleId);
            $this->roleId = $this->role->id;
            $this->name = $this->role->name;
            $this->selectedPermissions = $this->role->permissions->pluck('name')->toArray();
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:roles,name,' . $this->roleId,
            'selectedPermissions' => 'array',
        ];
    }

    public function save()
    {
        $this->validate();

        if ($this->roleId) {
            $this->role->update(['name' => $this->name]);
            $role = $this->role;
        } else {
            $role = Role::create([
                'name' => $this->name,
                'guard_name' => 'web'
            ]);
        }

        $role->syncPermissions($this->selectedPermissions);

        session()->flash(
            'message',
            $this->roleId ? 'Role and permissions updated successfully.' : 'Role created successfully.'
        );
        session()->flash('alert-type', 'success');

        return $this->redirectRoute('roles.list');
    }

    public function render()
    {
        $permissions = Permission::all();

        return view('livewire.roles.form', [
            'permissions' => $permissions,
        ]);
    }
}
