<div class="p-6 bg-white dark:bg-slate-800 rounded-xl min-h-[500px] w-full">
    <div class="w-full">
        
        <!-- Header -->
        <div class="mb-8 border-b border-slate-100 dark:border-slate-700/60 pb-6 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-800 dark:text-slate-100 tracking-tight">Reports</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Generate and download comprehensive PDF or CSV reports across system modules.</p>
            </div>
            <div class="hidden sm:flex p-3 bg-blue-50 dark:bg-blue-950/20 text-blue-600 dark:text-blue-400 rounded-2xl items-center justify-center">
                <i class="fa-solid fa-file-export text-2xl"></i>
            </div>
        </div>

        <form wire:submit.prevent="export" class="space-y-6">
            <!-- Report Type Select -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Report Type</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach([
                        ['id' => 'stock', 'label' => 'Stock Report', 'icon' => 'fa-boxes'],
                        ['id' => 'activity', 'label' => 'Activity Log', 'icon' => 'fa-history'],
                        ['id' => 'damage', 'label' => 'Damage Report', 'icon' => 'fa-house-damage'],
                        ['id' => 'sales', 'label' => 'Sales Log', 'icon' => 'fa-cart-shopping'],
                        ['id' => 'purchases', 'label' => 'Purchases Log', 'icon' => 'fa-bag-shopping'],
                        ['id' => 'transfers', 'label' => 'Transfers Log', 'icon' => 'fa-truck-ramp-box']
                    ] as $report)
                        <button type="button" wire:click="$set('reportType', '{{ $report['id'] }}')" 
                            class="flex flex-col items-center justify-center p-4 border rounded-xl text-center transition-all duration-200 {{ $reportType === $report['id'] ? 'bg-blue-600 border-blue-600 text-white shadow-lg shadow-blue-500/20' : 'bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:border-blue-400 dark:hover:border-slate-600' }}">
                            <i class="fa-solid {{ $report['icon'] }} text-lg mb-2"></i>
                            <span class="text-xs font-semibold">{{ $report['label'] }}</span>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Filters -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-100 dark:border-slate-700/60">
                <!-- Store Filter (Hidden for Activity report) -->
                @if($reportType !== 'activity')
                    <div class="space-y-1.5">
                        <label for="selectedStore" class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Store Filter</label>
                        <select wire:model.live="selectedStore" id="selectedStore" 
                            class="w-full px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">All Stores</option>
                            @foreach($stores as $store)
                                <option value="{{ $store->id }}">{{ $store->name }} ({{ $store->code }})</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <!-- Format Selection -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Export Format</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer py-2 px-4 border border-slate-200 dark:border-slate-700 rounded-lg flex-1 hover:bg-slate-50 dark:hover:bg-slate-850">
                            <input type="radio" wire:model.live="format" name="format" value="csv" class="text-blue-600 focus:ring-blue-500">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-350">CSV / Excel</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer py-2 px-4 border border-slate-200 dark:border-slate-700 rounded-lg flex-1 hover:bg-slate-50 dark:hover:bg-slate-850">
                            <input type="radio" wire:model.live="format" name="format" value="pdf" class="text-blue-600 focus:ring-blue-500">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-350">PDF Document</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Date Range Filters (Hidden for Stock Report) -->
            @if($reportType !== 'stock')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-100 dark:border-slate-700/60">
                    <div class="space-y-1.5">
                        <label for="startDate" class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Start Date</label>
                        <input type="date" wire:model="startDate" id="startDate" 
                            class="w-full px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="space-y-1.5">
                        <label for="endDate" class="block text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wider">End Date</label>
                        <input type="date" wire:model="endDate" id="endDate" 
                            class="w-full px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-sm text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            @endif

            <!-- Submit Button -->
            <div class="pt-6 border-t border-slate-100 dark:border-slate-700/60 flex justify-end">
                <button type="submit" 
                    class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition-all duration-200 shadow-lg shadow-blue-500/10 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <i class="fa-solid fa-download mr-2"></i>
                    Export {{ ucfirst($reportType) }} Report
                </button>
            </div>
        </form>
    </div>
</div>
