<?php

namespace App\Livewire\Categories;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use App\Services\UploadService;
use App\Repositories\Category\CategoryRepository;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class Form extends Component
{
    use WithFileUploads;

    public ?int $categoryId = null;
    public ?Category $category = null;

    public $name = '';
    public $description = '';
    public $parent_id = null;
    public $image;
    public $status = true;

    public function mount(?int $categoryId = null)
    {
        if ($categoryId) {
            $this->category = Category::findOrFail($categoryId);
            $this->categoryId = $this->category->id;

            $this->fill([
                'name' => $this->category->name,
                'description' => $this->category->description,
                'parent_id' => $this->category->parent_id,
                'status' => $this->category->status,
            ]);
        }
    }

    protected function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->ignore($this->categoryId),
            ],
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => [
                $this->categoryId ? 'nullable' : 'required',
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
        $repository = app(CategoryRepository::class);

        if ($this->image instanceof TemporaryUploadedFile) {
            $validated['image'] = $uploadService->uploadImage(
                $this->image,
                $this->category,
                'image',
                'categories'
            );
        } else {
            if ($this->categoryId && $this->category) {
                $validated['image'] = $this->category->image;
            } else {
                unset($validated['image']);
            }
        }

        $this->categoryId
            ? $repository->update($this->categoryId, $validated)
            : $repository->create($validated);

        session()->flash(
            'message',
            $this->categoryId ? 'Category Updated Successfully.' : 'Category Created Successfully.'
        );

        session()->flash('alert-type', 'success');

        return $this->redirectRoute('categories.list');
    }

    public function render()
    {
        $categories = Category::whereNull('parent_id')->get();

        return view('livewire.categories.form', [
            'categories' => $categories,
        ]);
    }
}
