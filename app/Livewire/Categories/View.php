<?php

namespace App\Livewire\Categories;

use Livewire\Component;
use App\Models\Category;

class View extends Component
{
    public $category;

    public function mount($categoryId)
    {
        $this->category = Category::with('parent', 'children')->findOrFail($categoryId);
    }

    public function render()
    {
        return view('livewire.categories.view');
    }
}
