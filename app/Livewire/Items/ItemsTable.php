<?php

namespace App\Livewire\Items;

use App\Models\Item;
use App\Livewire\DataTable;

class ItemsTable extends DataTable
{
    protected string $model = Item::class;

    protected $listeners = ['itemCreated' => 'resetPage'];

    protected array $modalConfig = [
        'create' => [
            'component' => 'items.create',
            'title' => 'Add New Item',
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
            'label' => 'SKU',
            'field' => 'sku',
            'width' => 'w-auto',
            'searchable' => true,
            'orderable' => true,
        ],
        [
            'label' => 'Name',
            'field' => 'name',
            'width' => 'w-auto',
            'searchable' => true,
            'orderable' => true,
        ],
        [
            'label' => 'Category',
            'field' => 'category_id',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'category',
            'orderable' => false,
        ],
        [
            'label' => 'Cost Price',
            'field' => 'cost_price',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'costPrice',
            'orderable' => true,
        ],
        [
            'label' => 'Selling Price',
            'field' => 'selling_price',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'sellingPrice',
            'orderable' => true,
        ],
        [
            'label' => 'Stock',
            'field' => 'stock_quantity',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'stock',
            'orderable' => true,
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
        'create' => 'items.create',
    ];

    protected function image($row)
    {
        if ($row->image) {
            $imgUrl = asset('storage/' . $row->image);
            return '<img src="' . $imgUrl . '" alt="Item Image" class="w-10 h-10 rounded-md object-cover">';
        }

        return '<div class="w-10 h-10 rounded-md bg-slate-200 flex items-center justify-center">
            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>';
    }

    protected function category($row)
    {
        if ($row->category) {
            return '<span class="text-sm text-slate-700">' . e($row->category->name) . '</span>';
        }
        return '<span class="text-xs text-slate-400">N/A</span>';
    }

    protected function price($row, $field)
    {
        return '<span class="text-sm font-medium text-slate-900">$' . number_format($row->$field, 2) . '</span>';
    }

    protected function costPrice($row)
    {
        return '<span class="text-sm font-medium text-slate-900">$' . number_format($row->cost_price, 2) . '</span>';
    }

    protected function sellingPrice($row)
    {
        return '<span class="text-sm font-medium text-slate-900">$' . number_format($row->selling_price, 2) . '</span>';
    }

    protected function stock($row)
    {
        $isLow = $row->stock_quantity <= $row->reorder_level;
        $class = $isLow ? 'text-red-600' : 'text-green-600';

        return '<span class="' . $class . ' font-semibold">' . $row->stock_quantity . '</span>';
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

    public function actions($item)
    {
        return view('components.items.items-actions', compact('item'));
    }

    public function delete($id): void
    {
        Item::findOrFail($id)->delete();
        session()->flash('success', 'Item deleted successfully.');
        $this->resetPage();
    }
}
