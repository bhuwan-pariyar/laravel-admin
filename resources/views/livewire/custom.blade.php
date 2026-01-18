@if ($paginator->hasPages())
    <div class="flex items-center justify-between">
        {{-- Results info --}}
        <div class="text-sm text-slate-600">
            Showing
            <span class="font-semibold text-slate-900">{{ $paginator->firstItem() }}</span>
            to
            <span class="font-semibold text-slate-900">{{ $paginator->lastItem() }}</span>
            of
            <span class="font-semibold text-slate-900">{{ $paginator->total() }}</span>
            results
        </div>

        {{-- Pagination buttons --}}
        <div class="flex items-center gap-1">
            {{-- Previous Button --}}
            @if ($paginator->onFirstPage())
                <span
                    class="px-3 py-1.5 text-sm font-medium text-slate-400 bg-slate-100 border border-slate-200 rounded-md cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </span>
            @else
                <button wire:click="previousPage" wire:loading.attr="disabled"
                    class="px-3 py-1.5 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-md hover:bg-slate-50 hover:border-slate-300 transition-all duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
            @endif

            {{-- Page Numbers --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="px-3 py-1.5 text-sm font-medium text-slate-400">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span
                                class="px-3 py-1.5 text-sm font-semibold text-white bg-blue-600 border border-blue-600 rounded-md shadow-sm">
                                {{ $page }}
                            </span>
                        @else
                            <button wire:click="gotoPage({{ $page }})"
                                class="px-3 py-1.5 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-md hover:bg-slate-50 hover:border-slate-300 transition-all duration-150">
                                {{ $page }}
                            </button>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Button --}}
            @if ($paginator->hasMorePages())
                <button wire:click="nextPage" wire:loading.attr="disabled"
                    class="px-3 py-1.5 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-md hover:bg-slate-50 hover:border-slate-300 transition-all duration-150">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            @else
                <span
                    class="px-3 py-1.5 text-sm font-medium text-slate-400 bg-slate-100 border border-slate-200 rounded-md cursor-not-allowed">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
            @endif
        </div>
    </div>
@endif
