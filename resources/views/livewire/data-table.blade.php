<div class="space-y-4">
    <div class="w-full">
        <div class="mb-2 flex items-center justify-between gap-4 flex-wrap">
            <div class="relative flex-1 max-w-xs">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search..."
                    class="w-full pl-10 pr-2 py-1.5 bg-white border border-slate-200 rounded-sm text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" />
            </div>
            <div class="flex items-center gap-3">
                @if (isset($executions['create']))
                    <a href="{{ route($executions['create']) }}"
                        class="px-4 py-1.5 bg-blue-600 border border-blue-600 rounded-sm text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add
                    </a>
                @endif
                @if (!empty($filters))
                    <button wire:click="$toggle('showFilters')"
                        class="px-4 py-1.5 bg-white border border-slate-200 rounded-sm text-sm font-medium text-slate-900 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filters
                    </button>
                @endif
                <div class="flex items-center gap-2">
                    <label class="text-sm text-slate-600">Show</label>
                    <select wire:model.live="perPage"
                        class="px-4 py-1.5 bg-white border border-slate-200 rounded-sm text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Panel -->
    @if ($showFilters && !empty($filters))
        <div class="bg-white border border-slate-200 rounded-sm p-4 space-y-3">
            <div class="flex items-center justify-between mb-3">
                <h3 class="font-semibold text-slate-900 text-sm">Filters</h3>
                <button wire:click="resetFilters" class="text-xs text-blue-600 hover:text-blue-700 font-medium">
                    Reset All
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                @foreach ($filters as $field => $filter)
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-medium text-slate-700">
                            {{ $filter['label'] ?? ucfirst(str_replace('_', ' ', $field)) }}
                        </label>

                        @if ($filter['type'] === 'select')
                            <select wire:model.live="filterValues.{{ $field }}"
                                class="px-2.5 py-1.5 bg-white border border-slate-300 rounded text-xs text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                <option value="">All</option>
                                @foreach ($filter['options'] as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        @elseif ($filter['type'] === 'range')
                            <div class="flex gap-2">
                                <input type="date" wire:model.live="filterValues.{{ $field }}.from"
                                    placeholder="From"
                                    class="flex-1 px-2.5 py-1.5 bg-white border border-slate-300 rounded text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" />
                                <input type="date" wire:model.live="filterValues.{{ $field }}.to"
                                    placeholder="To"
                                    class="flex-1 px-2.5 py-1.5 bg-white border border-slate-300 rounded text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" />
                            </div>
                        @else
                            <input type="text" wire:model.live="filterValues.{{ $field }}"
                                placeholder="Search..."
                                class="px-2.5 py-1.5 bg-white border border-slate-300 rounded text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" />
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-1xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr class="bg-gradient-to-r from-slate-50 to-slate-100 border-b border-slate-200">
                        @foreach ($columns as $column)
                            @if (isset($column['orderable']) && $column['orderable'])
                                <th wire:click="sortBy('{{ $column['field'] }}')"
                                    class="cursor-pointer px-4 py-2 text-left font-medium group {{ $column['width'] ?? 'w-auto' }}">
                                    <div class="flex items-center gap-1">
                                        <span>{{ $column['label'] }}</span>
                                        <span class="flex flex-col -space-y-3.5 leading-none">
                                            <svg class="w-4 h-4 {{ $sortField === $column['field'] && $sortDirection === 'asc' ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-400' }}"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 6l-6 6h12z" />
                                            </svg>
                                            <svg class="w-4 h-4 {{ $sortField === $column['field'] && $sortDirection === 'desc' ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-400' }}"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 18l6-6H6z" />
                                            </svg>
                                        </span>
                                    </div>
                                </th>
                            @else
                                <th
                                    class="cursor-pointer px-4 py-2 text-left font-medium group {{ $column['width'] ?? 'w-auto' }}">
                                    <div class="flex items-center gap-1">
                                        <span>{{ $column['label'] }}</span>

                                    </div>
                                </th>
                            @endif
                        @endforeach

                        @if (method_exists($this, 'actions'))
                            <th>Actions</th>
                        @endif
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200">
                    @forelse ($rows as $row)
                        <tr class="hover:bg-slate-50 transition-colors duration-150">
                            @foreach ($columns as $column)
                                <td class="px-4 py-2 text-sm text-slate-900">
                                    @if (isset($column['format']) && method_exists($this, $column['format']))
                                        {!! $this->{$column['format']}($row) !!}
                                    @else
                                        {{ data_get($row, $column['field']) }}
                                    @endif
                                </td>
                            @endforeach

                            @if (method_exists($this, 'actions'))
                                <td>
                                    {{ $this->actions($row) }}
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center text-slate-500">
                                    <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p class="text-sm font-medium">No results found</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if ($rows->hasPages())
        <div class="bg-slate-50 text-slate-900">
            {{ $rows->links('livewire.custom') }}
        </div>
    @endif
</div>
