<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class DataTable extends Component
{
    use WithPagination;

    protected $model;
    protected $columns = [];
    protected $filters = [];
    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $perPage = 10;
    public $activeFilters = [];
    public $showFilters = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'id'],
        'sortDirection' => ['except' => 'desc'],
        'activeFilters' => ['except' => []],
    ];

    public function mount($model, $columns, $filters = [])
    {
        $this->model = $model;
        $this->columns = $columns;
        $this->filters = $filters;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedActiveFilters()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->activeFilters = [];
        $this->resetPage();
    }

    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function getRowsProperty()
    {
        $query = $this->model::query();

        // Apply search
        if ($this->search) {
            $query->where(function (Builder $q) {
                foreach ($this->columns as $column) {
                    if ($column['searchable'] ?? true) {
                        $q->orWhere($column['field'], 'like', '%' . $this->search . '%');
                    }
                }
            });
        }

        // Apply filters
        foreach ($this->activeFilters as $field => $value) {
            if ($value !== '' && $value !== null) {
                $query->where($field, $value);
            }
        }

        // Apply sorting
        $query->orderBy($this->sortField, $this->sortDirection);

        return $query->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.data-table', [
            'rows' => $this->rows,
            'columns' => $this->columns,
            'filters' => $this->filters,
        ]);
    }
}
