<?php

namespace App\Livewire\Qr;

use App\Models\Item;
use Livewire\Component;
use Livewire\WithPagination;

class QrGenerator extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedItem = null;

    public function selectItem(int $itemId)
    {
        $this->selectedItem = Item::findOrFail($itemId)->toArray();
    }

    public function clearSelection()
    {
        $this->selectedItem = null;
    }

    public function render()
    {
        $items = Item::with('category')
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('sku', 'like', '%' . $this->search . '%')
                  ->orWhere('barcode', 'like', '%' . $this->search . '%');
            })
            ->paginate(10);

        return view('livewire.qr.qr-generator', [
            'items' => $items,
        ]);
    }
}
