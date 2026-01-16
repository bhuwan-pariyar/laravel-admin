<div x-data="{ open: false, mode: 'view', userId: null, user: {} }"
    @open-user-modal.window="
        open = true;
        mode = $event.detail.mode;
        userId = $event.detail.userId || null;
        if (userId) {
            fetch(`/api/users/${userId}`)
                .then(r => r.json())
                .then(data => user = data);
        } else {
            user = {};
        }
     "
    @keydown.escape.window="open = false" x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">

    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" @click="open = false" x-show="open"
        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

    <!-- Modal -->
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="relative bg-white rounded-lg shadow-xl max-w-2xl w-full mx-auto" x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" @click.away="open = false">

            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200">
                <h3 class="text-lg font-semibold text-slate-900">
                    <span x-show="mode === 'view'">View User</span>
                    <span x-show="mode === 'edit'">Edit User</span>
                    <span x-show="mode === 'add'">Add New User</span>
                </h3>
                <button @click="open = false" class="text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <div class="px-6 py-4">
                <form @submit.prevent="mode === 'add' || mode === 'edit' ? submitForm() : null">
                    <div class="space-y-4">
                        <!-- ID (View/Edit only) -->
                        <div x-show="mode !== 'add'">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">ID</label>
                            <input type="text" x-model="user.id" disabled
                                class="w-full px-4 py-2 bg-slate-100 border border-slate-200 rounded-lg text-slate-600 cursor-not-allowed">
                        </div>

                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Name</label>
                            <input type="text" x-model="user.name" :disabled="mode === 'view'"
                                :class="mode === 'view' ? 'bg-slate-100 cursor-not-allowed' : 'bg-white'"
                                class="w-full px-4 py-2 border border-slate-200 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                            <input type="email" x-model="user.email" :disabled="mode === 'view'"
                                :class="mode === 'view' ? 'bg-slate-100 cursor-not-allowed' : 'bg-white'"
                                class="w-full px-4 py-2 border border-slate-200 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Status</label>
                            <select x-model="user.status" :disabled="mode === 'view'"
                                :class="mode === 'view' ? 'bg-slate-100 cursor-not-allowed' : 'bg-white'"
                                class="w-full px-4 py-2 border border-slate-200 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <!-- Password (Add/Edit only) -->
                        <div x-show="mode !== 'view'">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Password <span x-show="mode === 'edit'" class="text-xs text-slate-500">(leave blank to
                                    keep current)</span>
                            </label>
                            <input type="password" x-model="user.password"
                                class="w-full px-4 py-2 border border-slate-200 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                :required="mode === 'add'">
                        </div>

                        <!-- Created At (View/Edit only) -->
                        <div x-show="mode !== 'add'">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Created At</label>
                            <input type="text" x-model="user.created_at" disabled
                                class="w-full px-4 py-2 bg-slate-100 border border-slate-200 rounded-lg text-slate-600 cursor-not-allowed">
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-slate-200">
                        <button type="button" @click="open = false"
                            class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">
                            <span x-show="mode === 'view'">Close</span>
                            <span x-show="mode !== 'view'">Cancel</span>
                        </button>

                        <button type="submit" x-show="mode !== 'view'"
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                            <span x-show="mode === 'add'">Create User</span>
                            <span x-show="mode === 'edit'">Update User</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function submitForm() {
        // Handle form submission here
        const data = this.user;
        const url = this.mode === 'add' ? '/api/users' : `/api/users/${this.userId}`;
        const method = this.mode === 'add' ? 'POST' : 'PUT';

        console.log('Submitting:', {
            mode: this.mode,
            data,
            url,
            method
        });

        // Example fetch request (uncomment and modify as needed):
        /*
        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        })
        .then(r => r.json())
        .then(response => {
            this.open = false;
            window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
        });
        */
    }
</script>
