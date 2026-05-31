<div class="relative" x-data="{ open: false }" @click.away="open = false" wire:poll.15s wire:ignore.self>
    <!-- Notification Bell Button -->
    <button type="button" @click="open = !open"
        class="relative text-slate-600 dark:text-gray-300 w-8 h-8 rounded-full flex items-center justify-center hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-all duration-200">
        <i class="fa-regular fa-bell text-lg"></i>
        
        <!-- Unread Badge -->
        @if ($this->unreadCount > 0)
            <span class="absolute top-1 right-1 flex h-4 w-4">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-4 w-4 bg-rose-500 text-[10px] font-bold text-white items-center justify-center">
                    {{ $this->unreadCount }}
                </span>
            </span>
        @endif
    </button>

    <!-- Dropdown Menu -->
    <div x-show="open" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95 translate-y-2"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
        x-transition:leave-end="opacity-0 scale-95 translate-y-2"
        class="absolute right-0 mt-3 w-80 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-md shadow-xl z-50 overflow-hidden"
        style="display: none;">
        
        <!-- Header -->
        <div class="px-4 py-3 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between bg-slate-50/50 dark:bg-slate-900/50">
            <span class="text-sm font-semibold text-slate-800 dark:text-slate-200">Notifications</span>
            @if ($this->unreadCount > 0)
                <button type="button" wire:click.stop="markAllAsRead" 
                    class="text-xs font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 hover:underline">
                    Mark all as read
                </button>
            @endif
        </div>

        <!-- Notification List -->
        <div class="max-h-80 overflow-y-auto divide-y divide-slate-100 dark:divide-slate-800/60">
            @forelse ($this->notifications as $notification)
                @php
                    $type = $notification->data['type'] ?? 'info';
                    $icon = $notification->data['icon'] ?? 'fa-solid fa-bell';
                    
                    $badgeColors = [
                        'success' => 'text-emerald-500 bg-emerald-50 dark:bg-emerald-500/10 dark:text-emerald-400',
                        'warning' => 'text-amber-500 bg-amber-50 dark:bg-amber-500/10 dark:text-amber-400',
                        'error' => 'text-rose-500 bg-rose-50 dark:bg-rose-500/10 dark:text-rose-400',
                        'danger' => 'text-rose-500 bg-rose-50 dark:bg-rose-500/10 dark:text-rose-400',
                        'info' => 'text-blue-500 bg-blue-50 dark:bg-blue-500/10 dark:text-blue-400',
                    ][$type] ?? 'text-slate-500 bg-slate-50 dark:bg-slate-500/10 dark:text-slate-400';
                @endphp
                <div wire:key="notification-{{ $notification->id }}" class="p-3.5 flex items-start gap-3 hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors duration-150 relative group {{ $notification->read_at ? 'opacity-70' : '' }}">
                    <!-- Icon -->
                    <span class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center text-sm {{ $badgeColors }}">
                        <i class="{{ $icon }}"></i>
                    </span>
                    
                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-1">
                            <span class="text-xs font-semibold text-slate-800 dark:text-slate-200 truncate">
                                {{ $notification->data['title'] ?? 'System Update' }}
                            </span>
                            <span class="text-[10px] text-slate-400 dark:text-slate-500 whitespace-nowrap">
                                {{ $notification->created_at->diffForHumans(null, true, true) }}
                            </span>
                        </div>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 line-clamp-2 leading-relaxed">
                            {{ $notification->data['message'] ?? '' }}
                        </p>
                    </div>

                    <!-- Action Check Button -->
                    @if (!$notification->read_at)
                        <button type="button" wire:click.stop="markAsRead('{{ $notification->id }}')"
                            class="absolute right-2 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-opacity duration-150 w-6 h-6 rounded-full bg-slate-100 dark:bg-slate-800 hover:bg-indigo-50 dark:hover:bg-indigo-950/40 text-slate-400 hover:text-indigo-600 dark:hover:text-indigo-400 flex items-center justify-center shadow-sm"
                            title="Mark as read">
                            <i class="fa-solid fa-check text-[10px]"></i>
                        </button>
                    @endif
                </div>
            @empty
                <div class="py-8 px-4 flex flex-col items-center justify-center text-slate-400 dark:text-slate-500">
                    <i class="fa-regular fa-bell-slash text-2xl mb-2 opacity-60"></i>
                    <span class="text-xs font-medium">No notifications yet</span>
                </div>
            @endforelse
        </div>
    </div>
</div>
