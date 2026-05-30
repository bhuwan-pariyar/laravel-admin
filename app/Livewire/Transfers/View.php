<?php

namespace App\Livewire\Transfers;

use App\Models\Transfer;
use Livewire\Component;

class View extends Component
{
    public Transfer $transfer;

    public function mount(int $transferId)
    {
        $this->transfer = Transfer::with(['fromStore', 'toStore', 'creator', 'items.item'])->findOrFail($transferId);
    }

    public function render()
    {
        return view('livewire.transfers.view');
    }
}
