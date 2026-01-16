<div wire:ignore.self x-data="{ show: @entangle('show') }" x-show="show" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 overflow-y-auto" style="display: none;">

    <!-- Backdrop -->
    <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm"
        @if ($closeable) @click="$wire.closeModal()" @endif></div>

    <!-- Modal Container -->
    <div class="flex min-h-full items-center justify-center p-4 sm:p-6">
        <div @if ($closeable) @click.away="$wire.closeModal()" @endif
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
            class="relative bg-white rounded-lg shadow-xl w-full transform transition-all
                @if ($size === 'sm') max-w-sm
                @elseif ($size === 'md') max-w-md
                @elseif ($size === 'lg') max-w-lg
                @elseif ($size === 'xl') max-w-xl
                @elseif ($size === '2xl') max-w-2xl
                @elseif ($size === '3xl') max-w-3xl
                @elseif ($size === 'full') max-w-7xl @endif
            ">

            {{-- Header --}}
            @if ($title)
                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-900">
                        {{ $title }}
                    </h3>

                    @if ($closeable)
                        <button wire:click="closeModal" type="button"
                            class="text-slate-400 hover:text-slate-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    @endif
                </div>
            @endif

            {{-- Body --}}
            <div class="max-h-[calc(100vh-200px)] overflow-y-auto p-6">
                @if ($component)
                    @livewire($component, $parameters, key($component . '-' . serialize($parameters)))
                @endif
            </div>

        </div>
    </div>
</div>
