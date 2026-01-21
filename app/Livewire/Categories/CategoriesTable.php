<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use App\Livewire\DataTable;

class CategoriesTable extends DataTable
{
    protected string $model = Category::class;

    protected $listeners = ['categoryCreated' => 'resetPage'];

    protected array $modalConfig = [
        'create' => [
            'component' => 'categories.create',
            'title' => 'Add New Category',
            'size' => 'md',
        ],
    ];

    protected array $columns = [
        [
            'label' => 'ID',
            'field' => 'id',
            'width' => 'w-20',
            'searchable' => false,
            'orderable' => true,
        ],
        [
            'label' => 'Image',
            'field' => 'image',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'image',
            'orderable' => false,
        ],
        [
            'label' => 'Name',
            'field' => 'name',
            'width' => 'w-auto',
            'searchable' => true,
            'orderable' => true,
        ],
        [
            'label' => 'Slug',
            'field' => 'slug',
            'width' => 'w-auto',
            'searchable' => true,
            'orderable' => true,
        ],
        [
            'label' => 'Parent',
            'field' => 'parent_id',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'parent',
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
            'label' => 'Date',
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
        'created_at' => [
            'type' => 'range',
            'label' => 'Range',
        ],
    ];

    protected array $executions = [
        'create' => 'categories.create',
    ];

    protected function image($row)
    {
        if ($row->image) {
            $imgUrl = asset('storage/' . $row->image);
            return '<img src="' . $imgUrl . '" alt="Category Image" class="w-10 h-10 rounded-md object-cover">';
        }

        return '<div class="w-10 h-10 rounded-md bg-slate-200 flex items-center justify-center">
            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>';
    }

    protected function parent($row)
    {
        if ($row->parent_id && $row->parent) {
            return '<span class="text-sm text-slate-700">' . e($row->parent->name) . '</span>';
        }
        return '<span class="text-xs text-slate-400">Root</span>';
    }

    protected function statusBadge($row)
    {
        $status = $row->status ? 'active' : 'inactive';

        $colors = [
            'active' => 'bg-green-100 text-green-800',
            'inactive' => 'bg-slate-100 text-slate-800',
        ];

        return '<span class="px-2.5 py-0.5 text-xs font-semibold rounded-full ' . $colors[$status] . '">' . ucfirst($status) . '</span>';
    }

    public function actions($category)
    {
        return view('components.categories.categories-actions', compact('category'));
    }

    public function delete($id): void
    {
        Category::findOrFail($id)->delete();
        session()->flash('success', 'Category deleted successfully.');
        $this->resetPage();
    }
}
