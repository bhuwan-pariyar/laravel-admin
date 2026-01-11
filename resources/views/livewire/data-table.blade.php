<div class="w-full">
    <!-- Search Bar and Filters -->
    <div class="mb-6 flex items-center justify-between gap-4 flex-wrap">
        <div class="relative flex-1 max-w-md">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search..."
                class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-sm text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" />
            @if ($search)
                <button wire:click="$set('search', '')"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            @endif
        </div>

        <div class="flex items-center gap-3">
            @if (count($filters) > 0)
                <button wire:click="toggleFilters"
                    class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filters
                    @if (count(array_filter($activeFilters)) > 0)
                        <span
                            class="ml-1 px-2 py-0.5 text-xs font-semibold bg-blue-600 text-white rounded-full">{{ count(array_filter($activeFilters)) }}</span>
                    @endif
                </button>
            @endif

            <div class="flex items-center gap-2">
                <label class="text-sm text-gray-600">Show</label>
                <select wire:model.live="perPage"
                    class="px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Filters Panel -->
    @if (count($filters) > 0 && $showFilters)
        <div class="mb-4 p-4 bg-gray-50 border border-gray-200 rounded-lg">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                    Filter Options
                </h3>
                @if (count(array_filter($activeFilters)) > 0)
                    <button wire:click="clearFilters"
                        class="px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                        Clear All
                    </button>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($filters as $filter)
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-2">
                            {{ $filter['label'] }}
                        </label>
                        <select wire:model.live="activeFilters.{{ $filter['field'] }}"
                            class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">All {{ $filter['label'] }}</option>
                            @foreach ($filter['options'] as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-1xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        @foreach ($columns as $column)
                            <th class="px-6 py-4 text-left {{ $column['width'] ?? 'w-auto' }}">
                                @if ($column['sortable'] ?? true)
                                    <button wire:click="sortBy('{{ $column['field'] }}')"
                                        class="flex items-center gap-2 text-xs font-semibold text-gray-700 uppercase tracking-wider hover:text-blue-600 transition-colors group">
                                        {{ $column['label'] }}
                                        <span class="flex flex-col">
                                            <svg class="w-3 h-3 {{ $sortField === $column['field'] && $sortDirection === 'asc' ? 'text-blue-600' : 'text-gray-400 group-hover:text-blue-400' }}"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" />
                                            </svg>
                                        </span>
                                    </button>
                                @else
                                    <span class="text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                        {{ $column['label'] }}
                                    </span>
                                @endif
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($rows as $row)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            @foreach ($columns as $column)
                                <td class="px-6 py-4 text-sm text-gray-900 {{ $column['width'] ?? 'w-auto' }}">
                                    @if (isset($column['format']))
                                        {!! $column['format']($row) !!}
                                    @else
                                        {{ data_get($row, $column['field']) }}
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($columns) }}" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <p class="text-sm font-medium">No results found</p>
                                    @if ($search)
                                        <p class="text-xs mt-1">Try adjusting your search terms</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($rows->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        Showing <span class="font-semibold text-gray-900">{{ $rows->firstItem() }}</span>
                        to <span class="font-semibold text-gray-900">{{ $rows->lastItem() }}</span>
                        of <span class="font-semibold text-gray-900">{{ $rows->total() }}</span> results
                    </div>

                    <div class="flex gap-1">
                        {{ $rows->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
