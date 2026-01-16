<div class="p-6">
    <!-- User Header -->
    <div class="flex items-center gap-4 pb-4 border-b border-slate-200">
        <div
            class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-lg">
            <span class="text-2xl font-bold text-white">{{ substr($user->name, 0, 1) }}</span>
        </div>
        <div class="flex-1">
            <h3 class="text-xl font-bold text-slate-900">{{ $user->name }}</h3>
            <p class="text-sm text-slate-500">{{ $user->email }}</p>
        </div>
        <div>
            @php
                $statusColors = [
                    'true' => 'bg-green-100 text-green-800 border-green-200',
                    'false' => 'bg-slate-100 text-slate-800 border-slate-200',
                ];
                $status = $user->status ?? 'true';
            @endphp
            <span class="px-3 py-1 text-xs font-semibold rounded-full border {{ $statusColors[$status] }}">
                {{ ucfirst($status) }}
            </span>
        </div>
    </div>

    <!-- User Details -->
    <div class="mt-6 space-y-4">
        <!-- ID -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                </svg>
                <span class="text-sm font-medium text-slate-600">User ID</span>
            </div>
            <span class="text-sm font-semibold text-slate-900">#{{ $user->id }}</span>
        </div>

        <!-- Email -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span class="text-sm font-medium text-slate-600">Email Address</span>
            </div>
            <span class="text-sm text-slate-900">{{ $user->email }}</span>
        </div>

        <!-- Email Verified -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-medium text-slate-600">Email Verified</span>
            </div>
            @if ($user->email_verified_at)
                <span class="flex items-center gap-1 text-sm text-green-600 font-medium">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    Verified
                </span>
            @else
                <span class="flex items-center gap-1 text-sm text-slate-500">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                    Not Verified
                </span>
            @endif
        </div>

        <!-- Created At -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="text-sm font-medium text-slate-600">Created At</span>
            </div>
            <div class="text-right">
                <p class="text-sm font-medium text-slate-900">{{ $user->created_at->format('M d, Y') }}</p>
                <p class="text-xs text-slate-500">{{ $user->created_at->format('h:i A') }}</p>
            </div>
        </div>

        <!-- Last Updated -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span class="text-sm font-medium text-slate-600">Last Updated</span>
            </div>
            <div class="text-right">
                <p class="text-sm font-medium text-slate-900">{{ $user->updated_at->format('M d, Y') }}</p>
                <p class="text-xs text-slate-500">{{ $user->updated_at->format('h:i A') }}</p>
            </div>
        </div>

        <!-- Account Age -->
        <div class="flex items-center justify-between py-3">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-medium text-slate-600">Account Age</span>
            </div>
            <span class="text-sm text-slate-900">{{ $user->created_at->diffForHumans() }}</span>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-slate-200">
        <button wire:click="$dispatch('closeModal')"
            class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-300 transition-colors">
            Close
        </button>
    </div>
</div>
