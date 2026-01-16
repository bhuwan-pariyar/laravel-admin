<div class="p-6">
    <form wire:submit="save">
        <div class="space-y-4">
            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700 mb-1">
                    Name <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" wire:model="name"
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('name') border-red-500 @enderror"
                    placeholder="Enter full name">
                @error('name')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700 mb-1">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" id="email" wire:model="email"
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('email') border-red-500 @enderror"
                    placeholder="user@example.com">
                @error('email')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-slate-700 mb-1">
                    Password <span class="text-red-500">*</span>
                </label>
                <input type="password" id="password" wire:model="password"
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('password') border-red-500 @enderror"
                    placeholder="Minimum 8 characters">
                @error('password')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Confirmation -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1">
                    Confirm Password <span class="text-red-500">*</span>
                </label>
                <input type="password" id="password_confirmation" wire:model="password_confirmation"
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                    placeholder="Re-enter password">
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-slate-700 mb-1">
                    Status <span class="text-red-500">*</span>
                </label>
                <select id="status" wire:model="status"
                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                    <option value="true">Active</option>
                    <option value="false">Inactive</option>
                </select>
                @error('status')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-slate-200">
            <button type="button" wire:click="$dispatch('closeModal')"
                class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-300 transition-colors">
                Cancel
            </button>
            <button type="submit" wire:loading.attr="disabled"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center gap-2">
                <span wire:loading.remove>Create User</span>
                <span wire:loading class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Creating...
                </span>
            </button>
        </div>
    </form>
</div>
