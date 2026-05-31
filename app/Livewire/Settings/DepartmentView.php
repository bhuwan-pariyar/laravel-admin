<?php

namespace App\Livewire\Settings;

use App\Models\Department;
use Livewire\Component;

class DepartmentView extends Component
{
    public $department;

    public function mount($departmentId)
    {
        $this->department = Department::findOrFail($departmentId);
    }

    public function render()
    {
        return view('livewire.settings.department-view');
    }
}
