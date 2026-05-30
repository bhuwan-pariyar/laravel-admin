<div class="relative"
    x-data="{ 
        open: false,
        toggleSearch() {
            this.open = !this.open;
            if (this.open) {
                this.$nextTick(() => { this.$refs.searchInput.focus(); });
            } else {
                this.$refs.searchInput.value = '';
                this.$refs.searchInput.dispatchEvent(new Event('input'));
            }
        },
        closeSearch() {
            this.open = false;
            this.$refs.searchInput.value = '';
            this.$refs.searchInput.dispatchEvent(new Event('input'));
        }
    }"
    @click.away="closeSearch()"
    @keydown.escape.window="closeSearch()"
>
    <!-- Search Trigger Button -->
    <button type="button" @click="toggleSearch()"
        class="text-slate-600 dark:text-gray-300 w-8 h-8 rounded-full flex items-center justify-center hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-all duration-200"
        title="Search (Ctrl+K)"
        >
        <i class="fa-solid fa-magnifying-glass text-lg"></i>
    </button>

    <!-- Search Dropdown Menu -->
    <div x-show="open" x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-2"
        class="absolute right-0 mt-3 w-80 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-md shadow-xl z-50 overflow-hidden"
        >
        
        <!-- Search Input -->
        <div class="p-3 border-b border-slate-100 dark:border-slate-800">
            <div class="relative w-full">
                <input 
                    wire:model.live.debounce.300ms="search" 
                    x-ref="searchInput"
                    type="text" 
                    placeholder="Search users, items, customers, suppliers..." 
                    class="w-full pl-10 pr-8 py-1.5 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/80 rounded-lg text-xs text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                />
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 dark:text-slate-500">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
                
                <!-- Loading Indicator / Clear Button -->
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center gap-1.5">
                    <div wire:loading wire:target="search" class="flex items-center">
                        <svg class="animate-spin h-3.5 w-3.5 text-indigo-500" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                    @if(!empty($search))
                        <button type="button" wire:click="$set('search', '')" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                            <i class="fa-solid fa-xmark text-xs"></i>
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Search Results -->
        <div class="max-h-80 overflow-y-auto py-1 divide-y divide-slate-100/60 dark:divide-slate-800/40">
            @if (strlen($search) < 2)
                <div class="py-6 px-4 flex flex-col items-center justify-center text-slate-400 dark:text-slate-500">
                    <i class="fa-solid fa-magnifying-glass text-xl mb-1.5 opacity-60"></i>
                    <span class="text-[11px] font-medium">Type at least 2 characters to search</span>
                </div>
            @elseif (empty($results))
                <div class="py-6 px-4 flex flex-col items-center justify-center text-slate-400 dark:text-slate-500">
                    <i class="fa-solid fa-face-frown text-xl mb-1.5 opacity-60"></i>
                    <span class="text-[11px] font-medium text-center">No results found for "{{ $search }}"</span>
                </div>
            @else
                @foreach ($results as $type => $items)
                    @if (count($items) > 0)
                        <div wire:key="search-group-{{ $type }}">
                            <div class="bg-slate-50 dark:bg-slate-800/40 px-3 py-1 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">
                                {{ $type }}
                            </div>
                            <ul class="divide-y divide-slate-100/40 dark:divide-slate-800/20">
                                @foreach ($items as $item)
                                    <li wire:key="search-item-{{ md5($item['url']) }}">
                                        <a href="{{ $item['url'] }}" class="px-3.5 py-2 flex items-center hover:bg-slate-50 dark:hover:bg-slate-800/50 group transition-all duration-150" wire:navigate>
                                            @if(!empty($item['image']))
                                                <img src="{{ $item['image'] }}" alt="" class="w-7 h-7 rounded-md block object-cover align-middle mr-2.5 bg-slate-100 border border-slate-200/60 dark:border-slate-700/50">
                                            @else
                                                <div class="w-7 h-7 rounded-md flex items-center justify-center bg-indigo-50 dark:bg-indigo-950/40 text-indigo-500 dark:text-indigo-400 mr-2.5">
                                                    <i class="{{ $item['icon'] }} text-xs"></i>
                                                </div>
                                            @endif
                                            <div class="min-w-0 flex-1">
                                                <div class="text-[11.5px] font-semibold text-slate-700 dark:text-slate-200 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 truncate">
                                                    {{ $item['title'] }}
                                                </div>
                                                @if(!empty($item['subtitle']))
                                                    <div class="text-[10px] text-slate-400 dark:text-slate-500 truncate mt-0.5">
                                                        {{ $item['subtitle'] }}
                                                    </div>
                                                @endif
                                            </div>
                                            <i class="fa-solid fa-chevron-right text-[9px] text-slate-300 dark:text-slate-600 opacity-0 group-hover:opacity-100 transition-opacity ml-2"></i>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>

</div>
