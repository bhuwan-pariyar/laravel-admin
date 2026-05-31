<div class="p-6">
    <!-- Damage Header -->
    <div class="flex items-center gap-4 pb-4 border-b border-slate-200 dark:border-slate-800">
        <div class="w-16 h-16 rounded-lg bg-rose-100 dark:bg-rose-950/30 flex items-center justify-center shadow-lg">
            <i class="fa-solid fa-house-damage text-2xl text-rose-600 dark:text-rose-400"></i>
        </div>
        <div class="flex-1">
            <h3 class="text-xl font-bold text-slate-900 dark:text-slate-100">Damage Report Details</h3>
            <p class="text-sm text-slate-500">Item: <span class="font-semibold text-slate-700 dark:text-slate-350">{{ $report->item->name ?? 'Unknown' }}</span></p>
        </div>
        <div class="text-right">
            <span class="px-3 py-1 text-sm font-bold bg-rose-100 text-rose-800 dark:bg-rose-950/40 dark:text-rose-400 rounded-lg">
                Qty: {{ $report->quantity }}
            </span>
        </div>
    </div>

    <!-- Details -->
    <div class="mt-6 space-y-4">
        <!-- ID -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100 dark:border-slate-800/60">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-hashtag text-slate-400"></i>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Report ID</span>
            </div>
            <span class="text-sm font-semibold text-slate-900 dark:text-slate-100">#{{ $report->id }}</span>
        </div>

        <!-- Item Details -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100 dark:border-slate-800/60">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-box text-slate-400"></i>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Item SKU</span>
            </div>
            <span class="text-sm font-mono text-slate-900 dark:text-slate-100 bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded">{{ $report->item->sku ?? 'N/A' }}</span>
        </div>

        <!-- Store Details -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100 dark:border-slate-800/60">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-store text-slate-400"></i>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Store</span>
            </div>
            <span class="text-sm text-slate-900 dark:text-slate-200">{{ $report->store->name ?? 'N/A' }} ({{ $report->store->code ?? '' }})</span>
        </div>

        <!-- Reporter Details -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100 dark:border-slate-800/60">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-user-edit text-slate-400"></i>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Reported By</span>
            </div>
            <span class="text-sm text-slate-900 dark:text-slate-200">{{ $report->reporter->name ?? 'Unknown' }}</span>
        </div>

        <!-- Reported Date -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100 dark:border-slate-800/60">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-calendar text-slate-400"></i>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Reported Date</span>
            </div>
            <span class="text-sm text-slate-900 dark:text-slate-200">{{ $report->reported_at ? $report->reported_at->format('Y-m-d H:i') : 'N/A' }}</span>
        </div>

        <!-- Remarks -->
        <div class="py-3 border-b border-slate-100 dark:border-slate-800/60">
            <div class="flex items-center gap-2 mb-2">
                <i class="fa-solid fa-comment-dots text-slate-400"></i>
                <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Remarks</span>
            </div>
            <p class="text-sm text-slate-700 dark:text-slate-350 ml-7 bg-slate-50 dark:bg-slate-800/50 p-3 rounded-lg border border-slate-100 dark:border-slate-800/60">{{ $report->remarks ?? 'No remarks provided.' }}</p>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-slate-200 dark:border-slate-800">
        <a href="{{ route('damage.list') }}"
            class="px-4 py-1 bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-sm text-sm font-medium hover:bg-slate-300 dark:hover:bg-slate-700 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>&nbsp; Back
        </a>
    </div>
</div>
