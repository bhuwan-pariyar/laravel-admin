<div class="p-6">
    <!-- Supplier Header -->
    <div class="flex items-center gap-4 pb-4 border-b border-slate-200">
        <div class="w-16 h-16 rounded-lg bg-slate-900 text-white flex items-center justify-center shadow-lg font-bold text-2xl">
            {{ strtoupper(substr($supplier->name, 0, 1)) }}
        </div>
        <div class="flex-1">
            <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100">{{ $supplier->name }}</h3>
            <p class="text-sm text-slate-500">{{ $supplier->email ?? 'No email provided' }}</p>
        </div>
        <div>
            @php
                $statusColors = [
                    'active' => 'bg-green-100 text-green-800 border-green-200 dark:bg-green-950/30 dark:text-green-400 dark:border-green-900/40',
                    'inactive' => 'bg-slate-100 text-slate-800 border-slate-200 dark:bg-slate-800/40 dark:text-slate-400 dark:border-slate-700/40',
                ];
                $status = $supplier->status ? 'active' : 'inactive';
            @endphp
            <span class="px-3 py-0.5 text-xs font-semibold rounded-full border {{ $statusColors[$status] }}">
                {{ ucfirst($status) }}
            </span>
        </div>
    </div>

    <!-- Supplier Details -->
    <div class="mt-6 space-y-4">
        <!-- ID -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100 dark:border-slate-800/60">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-hashtag text-slate-400"></i>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Supplier ID</span>
            </div>
            <span class="text-sm font-semibold text-slate-900 dark:text-slate-100">#{{ $supplier->id }}</span>
        </div>

        <!-- Name -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100 dark:border-slate-800/60">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-truck text-slate-400"></i>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Name</span>
            </div>
            <span class="text-sm text-slate-900 dark:text-slate-200">{{ $supplier->name }}</span>
        </div>

        <!-- Phone -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100 dark:border-slate-800/60">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-phone text-slate-400"></i>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Phone</span>
            </div>
            <span class="text-sm text-slate-900 dark:text-slate-200">{{ $supplier->phone ?? 'N/A' }}</span>
        </div>

        <!-- Address -->
        <div class="py-3 border-b border-slate-100 dark:border-slate-800/60">
            <div class="flex items-center gap-2 mb-2">
                <i class="fa-solid fa-map-marker-alt text-slate-400"></i>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Address</span>
            </div>
            <p class="text-sm text-slate-700 dark:text-slate-300 ml-6">{{ $supplier->address ?? 'No address provided' }}</p>
        </div>

        <!-- Created At -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100 dark:border-slate-800/60">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-calendar-alt text-slate-400"></i>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Created At</span>
            </div>
            <div class="text-right">
                <p class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $supplier->created_at->format('M d, Y') }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $supplier->created_at->format('h:i A') }}</p>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-slate-200 dark:border-slate-800">
        <a href="{{ route('suppliers.list') }}"
            class="px-4 py-1 bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-sm text-sm font-medium hover:bg-slate-300 dark:hover:bg-slate-700 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>&nbsp; Back
        </a>
    </div>
</div>
