<div class="p-6">
    <!-- Warning Icon & Message -->
    <div class="flex items-start gap-4 mb-6">
        <div class="flex-shrink-0 w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <div class="flex-1">
            <h3 class="text-lg font-semibold text-slate-900 mb-2">Delete User</h3>
            <p class="text-sm text-slate-600">
                Are you sure you want to delete
                <span class="font-semibold text-slate-900">{{ $user->name }}</span>
                ({{ $user->email }})?
            </p>
        </div>
    </div>

    <!-- User Details Card -->
    <div class="mb-6 p-4 bg-slate-50 border border-slate-200 rounded-lg">
        <div class="flex items-center gap-3">
            <div
                class="w-10 h-10 bg-gradient-to-br from-slate-400 to-slate-500 rounded-full flex items-center justify-center">
                <span class="text-lg font-bold text-white">{{ substr($user->name, 0, 1) }}</span>
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-slate-900">{{ $user->name }}</p>
                <p class="text-xs text-slate-500">ID: #{{ $user->id }}</p>
            </div>
            @php
                $statusColors = [
                    'true' => 'bg-green-100 text-green-800',
                    'false' => 'bg-slate-100 text-slate-800',
                ];
                $status = $user->status ?? 'true';
            @endphp
            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$status] }}">
                {{ ucfirst($status) }}
            </span>
        </div>
    </div>

    <!-- Warning Box -->
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
        <div class="flex items-start gap-2">
            <svg class="w-5 h-5 text-red-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                    clip-rule="evenodd" />
            </svg>
            <div class="text-xs text-red-800">
                <p class="font-semibold mb-1">Warning: This action cannot be undone!</p>
                <ul class="list-disc list-inside space-y-1 text-red-700">
                    <li>All user data will be permanently deleted</li>
                    <li>User will lose access immediately</li>
                    <li>This action is irreversible</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Confirmation Input -->
    <div class="mb-6">
        <label for="confirmText" class="block text-sm font-medium text-slate-700 mb-2">
            Type <span class="font-mono font-bold text-red-600">DELETE</span> to confirm
        </label>
        <input type="text" id="confirmText" wire:model="confirmText"
            class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all @error('confirmText') border-red-500 @enderror"
            placeholder="Type DELETE">
        @error('confirmText')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200">
        <button type="button" wire:click="$dispatch('closeModal')"
            class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-300 transition-colors">
            Cancel
        </button>
        <button type="button" wire:click="delete" wire:loading.attr="disabled"
            class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
            <span wire:loading.remove>
                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Delete User
            </span>
            <span wire:loading class="flex items-center gap-2">
                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                Deleting...
            </span>
        </button>
    </div>
</div>
