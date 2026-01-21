<?php

namespace App\Livewire\Items;

use App\Models\Item;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use App\Services\UploadService;
use App\Repositories\Item\ItemRepository;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class Form extends Component
{
    use WithFileUploads;

    public ?int $itemId = null;
    public ?Item $item = null;

    public $category_id = '';
    public $name = '';
    public $sku = '';
    public $barcode = '';
    public $description = '';
    public $cost_price = '';
    public $selling_price = '';
    public $stock_quantity = 0;
    public $reorder_level = 5;
    public $image;
    public $status = true;

    public function mount(?int $itemId = null)
    {
        if ($itemId) {
            $this->item = Item::findOrFail($itemId);
            $this->itemId = $this->item->id;

            $this->fill([
                'category_id' => $this->item->category_id,
                'name' => $this->item->name,
                'sku' => $this->item->sku,
                'barcode' => $this->item->barcode,
                'description' => $this->item->description,
                'cost_price' => $this->item->cost_price,
                'selling_price' => $this->item->selling_price,
                'stock_quantity' => $this->item->stock_quantity,
                'reorder_level' => $this->item->reorder_level,
                'status' => $this->item->status,
            ]);
        }
    }

    protected function rules()
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sku' => [
                'required',
                'string',
                'max:255',
                Rule::unique('items', 'sku')->ignore($this->itemId),
            ],
            'barcode' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'cost_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
            'image' => [
                $this->itemId ? 'nullable' : 'required',
                'image',
                'max:2048',
            ],
            'status' => 'required|boolean',
        ];
    }

    public function save()
    {
        $validated = $this->validate();
        $uploadService = app(UploadService::class);
        $repository = app(ItemRepository::class);

        if ($this->image instanceof TemporaryUploadedFile) {
            $validated['image'] = $uploadService->uploadImage(
                $this->image,
                $this->item,
                'image',
                'items'
            );
        } else {
            if ($this->itemId && $this->item) {
                $validated['image'] = $this->item->image;
            } else {
                unset($validated['image']);
            }
        }

        $this->itemId
            ? $repository->update($this->itemId, $validated)
            : $repository->create($validated);

        session()->flash(
            'message',
            $this->itemId ? 'Item Updated Successfully.' : 'Item Created Successfully.'
        );

        session()->flash('alert-type', 'success');

        return $this->redirectRoute('items.list');
    }

    public function render()
    {
        $categories = Category::where('status', true)->get();

        return view('livewire.items.form', [
            'categories' => $categories,
        ]);
    }
}
