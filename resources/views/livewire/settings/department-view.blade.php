<div class="p-6">
    <!-- Department Header -->
    <div class="flex items-center gap-4 pb-4 border-b border-slate-200 dark:border-slate-800">
        <div class="w-16 h-16 rounded-lg bg-blue-100 dark:bg-blue-950/30 flex items-center justify-center shadow-lg">
            <i class="fa-solid fa-building text-2xl text-blue-600 dark:text-blue-400"></i>
        </div>
        <div class="flex-1">
            <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100">{{ $department->name }}</h3>
            <p class="text-sm text-slate-500">Code: <span class="font-semibold text-slate-700 dark:text-slate-350">{{ $department->code }}</span></p>
        </div>
        <div>
            @php
                $statusColors = [
                    'active' => 'bg-green-100 text-green-800 border-green-200 dark:bg-green-950/30 dark:text-green-400 dark:border-green-900/40',
                    'inactive' => 'bg-slate-100 text-slate-800 border-slate-200 dark:bg-slate-800/40 dark:text-slate-400 dark:border-slate-700/40',
                ];
                $status = $department->status ? 'active' : 'inactive';
            @endphp
            <span class="px-3 py-0.5 text-xs font-semibold rounded-full border {{ $statusColors[$status] }}">
                {{ ucfirst($status) }}
            </span>
        </div>
    </div>

    <!-- Department Details -->
    <div class="mt-6 space-y-4">
        <!-- ID -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100 dark:border-slate-800/60">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-hashtag text-slate-400"></i>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Department ID</span>
            </div>
            <span class="text-sm font-semibold text-slate-900 dark:text-slate-100">#{{ $department->id }}</span>
        </div>

        <!-- Code -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100 dark:border-slate-800/60">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-qrcode text-slate-400"></i>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Code</span>
            </div>
            <span class="text-sm text-slate-900 dark:text-slate-100 font-mono bg-slate-50 dark:bg-slate-800/50 px-2 py-1 rounded">{{ $department->code }}</span>
        </div>

        <!-- Name -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100 dark:border-slate-800/60">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-font text-slate-400"></i>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Name</span>
            </div>
            <span class="text-sm text-slate-900 dark:text-slate-200">{{ $department->name }}</span>
        </div>

        <!-- Description -->
        @if ($department->description)
            <div class="py-3 border-b border-slate-100 dark:border-slate-800/60">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fa-solid fa-align-left text-slate-400"></i>
                    <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Description</span>
                </div>
                <p class="text-sm text-slate-700 dark:text-slate-350 ml-7 bg-slate-50 dark:bg-slate-800/50 p-3 rounded-lg border border-slate-100 dark:border-slate-800/60">{{ $department->description }}</p>
            </div>
        @endif

        <!-- Created At -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100 dark:border-slate-800/60">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-calendar text-slate-400"></i>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Created At</span>
            </div>
            <div class="text-right">
                <p class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $department->created_at->format('M d, Y') }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $department->created_at->format('h:i A') }}</p>
            </div>
        </div>

        <!-- Last Updated -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100 dark:border-slate-800/60">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-slate-400"></i>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Last Updated</span>
            </div>
            <div class="text-right">
                <p class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $department->updated_at->format('M d, Y') }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $department->updated_at->format('h:i A') }}</p>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-slate-200 dark:border-slate-800">
        <a href="{{ route('settings.departments.list') }}"
            class="px-4 py-1 bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-sm text-sm font-medium hover:bg-slate-300 dark:hover:bg-slate-700 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>&nbsp; Back
        </a>
    </div>
</div>
