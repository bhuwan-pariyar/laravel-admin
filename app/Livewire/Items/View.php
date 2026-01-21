<?php

namespace App\Livewire\Items;

use Livewire\Component;
use App\Models\Item;

class View extends Component
{
    public $item;

    public function mount($itemId)
    {
        $this->item = Item::with('category')->findOrFail($itemId);
    }

    public function render()
    {
        return view('livewire.items.view');
    }
}
