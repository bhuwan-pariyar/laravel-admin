<?php

namespace App\Livewire\Damage;

use Livewire\Component;
use App\Models\DamageReport;

class View extends Component
{
    public $report;

    public function mount($damageId)
    {
        $this->report = DamageReport::with(['item', 'store', 'reporter'])->findOrFail($damageId);
    }

    public function render()
    {
        return view('livewire.damage.view');
    }
}
