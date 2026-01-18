<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Illuminate\Database\Eloquent\Builder;

class DataTable extends Component
{
    use WithPagination,WithoutUrlPagination;

    public $model;

    public $search = '';
    public $sortField = 'id';
    public $sortDirection = 'desc';
    public $perPage = 15;
    public $activeFilters = [];
    public $showFilters = false;
    public $add = false;

    // These contain closures, so they must be protected
    protected $columns = [];
    protected $filters = [];
    protected $modalConfig = [];

    // Store serializable column/filter configuration
    public $columnsConfig = [];
    public $filtersConfig = [];
    public $modalConfigData = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'sortField' => ['except' => 'id'],
        'sortDirection' => ['except' => 'desc'],
        'activeFilters' => ['except' => []],
    ];

    // Listen for refresh events from modals
    protected $listeners = [
        'refreshTable' => '$refresh',
        'itemCreated' => '$refresh',
        'itemUpdated' => '$refresh',
        'itemDeleted' => '$refresh',
    ];

    public function mount($model, $columns, $filters = [], $add = false, $modalConfig = [])
    {
        $this->model = $model;
        $this->columns = $columns;
        $this->filters = $filters;
        $this->add = $add;
        $this->modalConfig = $modalConfig;
        $this->activeFilters = [];
        $this->search = '';
        $this->sortField = 'id';
        $this->sortDirection = 'asc';
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
        // logger()->info('Sorting by field', ['field' => $field]);
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    // Open modal for creating new item
    public function openCreateModal()
    {
        $component = $this->modalConfig['create']['component'] ?? null;
        logger()->info('Opening Create Modal', ['component' => $component]);
        if (!$component) {
            return;
        }

        $this->dispatch('openModal',
            component: $component,
            parameters: $this->modalConfig['create']['parameters'] ?? [],
            config: [
                'title' => $this->modalConfig['create']['title'] ?? 'Create New',
                'size' => $this->modalConfig['create']['size'] ?? 'lg',
            ]
        );
    }

    // Open modal for editing item
    public function openEditModal($id)
    {
        $component = $this->modalConfig['edit']['component'] ?? null;
        logger()->info('Opening Edit Modal', ['component' => $component, 'id' => $id]);
        if (!$component) {
            return;
        }

        $parameters = array_merge(
            $this->modalConfig['edit']['parameters'] ?? [],
            [$this->modalConfig['edit']['id_param'] ?? 'id' => $id]
        );

        $this->dispatch('openModal',
            component: $component,
            parameters: $parameters,
            config: [
                'title' => $this->modalConfig['edit']['title'] ?? 'Edit',
                'size' => $this->modalConfig['edit']['size'] ?? 'lg',
            ]
        );
    }

    // Open modal for viewing item
    public function openViewModal($id)
    {
        $component = $this->modalConfig['view']['component'] ?? null;
        logger()->info('Opening View Modal', ['component' => $component, 'id' => $id]);
        if (!$component) {
            return;
        }

        $parameters = array_merge(
            $this->modalConfig['view']['parameters'] ?? [],
            [$this->modalConfig['view']['id_param'] ?? 'id' => $id]
        );

        $this->dispatch('openModal',
            component: $component,
            parameters: $parameters,
            config: [
                'title' => $this->modalConfig['view']['title'] ?? 'View Details',
                'size' => $this->modalConfig['view']['size'] ?? 'md',
            ]
        );
    }

    // Open modal for deleting item
    public function openDeleteModal($id)
    {
        $component = $this->modalConfig['delete']['component'] ?? null;
        logger()->info('Opening Delete Modal', ['component' => $component, 'id' => $id]);
        if (!$component) {
            return;
        }

        $parameters = array_merge(
            $this->modalConfig['delete']['parameters'] ?? [],
            [$this->modalConfig['delete']['id_param'] ?? 'id' => $id]
        );

        $this->dispatch('openModal',
            component: $component,
            parameters: $parameters,
            config: [
                'title' => $this->modalConfig['delete']['title'] ?? 'Confirm Delete',
                'size' => $this->modalConfig['delete']['size'] ?? 'md',
            ]
        );
    }

    public function getRowsProperty()
    {
        $modelClass = $this->model;

        $query = $modelClass::query();

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
            'add' => $this->add,
        ]);
    }
}
