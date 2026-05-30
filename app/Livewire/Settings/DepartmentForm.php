<?php

namespace App\Livewire\Settings;

use App\Models\Department;
use Livewire\Component;

class DepartmentForm extends Component
{
    public $departmentId;
    public $name = '';
    public $code = '';
    public $description = '';
    public $status = true;

    public function mount($departmentId = null)
    {
        $this->departmentId = $departmentId;
        if ($this->departmentId) {
            $department = Department::findOrFail($this->departmentId);
            $this->name = $department->name;
            $this->code = $department->code;
            $this->description = $department->description;
            $this->status = $department->status;
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:20|unique:departments,code,' . $this->departmentId,
            'description' => 'nullable|string|max:1000',
            'status' => 'boolean',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        if ($this->departmentId) {
            $department = Department::findOrFail($this->departmentId);
            $department->update($validated);
            session()->flash('message', 'Department updated successfully.');
        } else {
            Department::create($validated);
            session()->flash('message', 'Department created successfully.');
        }

        session()->flash('alert-type', 'success');

        return $this->redirectRoute('settings.departments.list');
    }

    public function render()
    {
        return view('livewire.settings.department-form');
    }
}
