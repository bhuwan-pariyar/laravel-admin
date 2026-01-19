<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

abstract class DataTable extends Component
{
    use WithPagination;

    protected string $model;
    protected array $columns = [];
    protected array $filters = [];
    protected array $modalConfig = [
        'create' => [
            'component' => null,
            'title' => 'Create New',
            'size' => 'md',
            'parameters' => [],
        ],
    ];
    protected array $executions = [];

    public string $search = '';
    public string $sortField = 'id';
    public string $sortDirection = 'desc';
    public int $perPage = 15;
    public array $filterValues = [];
    public bool $showFilters = false;

    protected function query(): Builder
    {
        return $this->model::query()
            ->when($this->search, function ($q) {
                $this->applySearch($q);
            })
            ->when(!empty($this->filterValues), function ($q) {
                $this->applyFilters($q);
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    protected function applySearch(Builder $query): void
    {
        $query->where(function ($q) {
            foreach ($this->columns as $column) {
                if (!empty($column['searchable'])) {
                    $q->orWhere($column['field'], 'like', "%{$this->search}%");
                }
            }
        });
    }

    protected function applyFilters(Builder $query): void
    {
        foreach ($this->filterValues as $field => $value) {
            if (!isset($this->filters[$field])) {
                continue;
            }

            $filter = $this->filters[$field];

            if (isset($filter['type']) && $filter['type'] === 'range') {
                if (isset($value['from']) && $value['from'] !== '') {
                    $query->whereDate($field, '>=', $value['from']);
                }
                if (isset($value['to']) && $value['to'] !== '') {
                    $query->whereDate($field, '<=', $value['to']);
                }
            }
            elseif ($value !== '' && $value !== null) {
                $query->where($field, $value);
            }
        }
    }

    public function resetFilters(): void
    {
        $this->filterValues = [];
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function openCreateModal()
    {
        $component = $this->modalConfig['create']['component'] ?? null;

        if (!$component) {
            return;
        }
        $this->dispatch('openModal',
            component: $component,
            parameters: $this->modalConfig['create']['parameters'] ?? [],
            config: [
                'title' => $this->modalConfig['create']['title'] ?? 'Create New',
                'size' => $this->modalConfig['create']['size'] ?? 'md',
            ]
        );
    }

    public function render()
    {
        return view('livewire.data-table', [
            'rows' => $this->query()->paginate($this->perPage),
            'columns' => $this->columns,
            'filters' => $this->filters,
            'executions' => $this->executions,
        ]);
    }
}
