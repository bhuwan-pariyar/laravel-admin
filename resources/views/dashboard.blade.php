<x-app-layout>
    <div class="px-6 py-6">
        
        <!-- Welcome Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Dashboard</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Real-time business performance, inventory metrics, and recent actions.</p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-600 dark:text-emerald-400">
                    <span class="w-1.5 h-1.5 inline-block rounded-full bg-emerald-600 dark:bg-emerald-400 animate-ping"></span>
                    Live System Status
                </span>
                <div class="text-sm text-slate-400 dark:text-slate-500 font-medium">
                    {{ now()->format('l, F d, Y') }}
                </div>
            </div>
        </div>

        <!-- Premium KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Card: Sales -->
            <div class="relative overflow-hidden bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 p-6 shadow-sm hover:shadow-md transition-all duration-300 group">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-indigo-500/10 rounded-full blur-xl group-hover:scale-125 transition-transform duration-500"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Total Sales Revenue</span>
                        <h3 class="text-2xl font-bold text-slate-800 dark:text-white mt-1">
                            ${{ number_format($totalSales, 2) }}
                        </h3>
                    </div>
                    <div class="p-3 bg-indigo-500/10 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 rounded-xl">
                        <i class="ri-shopping-cart-2-line text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs">
                    <span class="text-emerald-500 font-semibold flex items-center gap-0.5">
                        <i class="ri-arrow-up-line"></i> Active
                    </span>
                    <span class="text-slate-400 dark:text-slate-500 ml-2">sales records processed</span>
                </div>
            </div>

            <!-- Card: Purchases -->
            <div class="relative overflow-hidden bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 p-6 shadow-sm hover:shadow-md transition-all duration-300 group">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-sky-500/10 rounded-full blur-xl group-hover:scale-125 transition-transform duration-500"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Total Purchases Cost</span>
                        <h3 class="text-2xl font-bold text-slate-800 dark:text-white mt-1">
                            ${{ number_format($totalPurchases, 2) }}
                        </h3>
                    </div>
                    <div class="p-3 bg-sky-500/10 dark:bg-sky-500/20 text-sky-600 dark:text-sky-400 rounded-xl">
                        <i class="ri-wallet-3-line text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs">
                    <span class="text-sky-500 font-semibold flex items-center gap-0.5">
                        <i class="ri-refresh-line"></i> Linked
                    </span>
                    <span class="text-slate-400 dark:text-slate-500 ml-2">to inventory replenishment</span>
                </div>
            </div>

            <!-- Card: Inventory Value -->
            <div class="relative overflow-hidden bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 p-6 shadow-sm hover:shadow-md transition-all duration-300 group">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-emerald-500/10 rounded-full blur-xl group-hover:scale-125 transition-transform duration-500"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Inventory Valuation</span>
                        <h3 class="text-2xl font-bold text-slate-800 dark:text-white mt-1" title="Retail: ${{ number_format($inventoryRetailValue, 2) }} / Cost: ${{ number_format($inventoryCostValue, 2) }}">
                            ${{ number_format($inventoryRetailValue, 2) }}
                        </h3>
                    </div>
                    <div class="p-3 bg-emerald-500/10 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 rounded-xl">
                        <i class="ri-database-2-line text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex flex-col space-y-1">
                    <div class="flex justify-between text-[11px] text-slate-400 dark:text-slate-500">
                        <span>Cost Basis:</span>
                        <span class="font-medium text-slate-600 dark:text-slate-300">${{ number_format($inventoryCostValue, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Card: Stock Status -->
            <div class="relative overflow-hidden bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 p-6 shadow-sm hover:shadow-md transition-all duration-300 group">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-amber-500/10 rounded-full blur-xl group-hover:scale-125 transition-transform duration-500"></div>
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Alerts & Customers</span>
                        <div class="flex items-center gap-3 mt-1">
                            <span class="text-2xl font-bold text-slate-800 dark:text-white">{{ $lowStockCount + $outOfStockCount }}</span>
                            <span class="text-xs text-slate-400">alerts</span>
                            <span class="text-slate-300 dark:text-slate-700">|</span>
                            <span class="text-2xl font-bold text-slate-800 dark:text-white">{{ $totalCustomers }}</span>
                            <span class="text-xs text-slate-400">clients</span>
                        </div>
                    </div>
                    <div class="p-3 bg-amber-500/10 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 rounded-xl">
                        <i class="ri-alert-line text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center justify-between text-xs">
                    <span class="flex items-center gap-1 text-rose-500 font-medium">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> {{ $outOfStockCount }} OOS
                    </span>
                    <span class="flex items-center gap-1 text-amber-500 font-medium">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> {{ $lowStockCount }} Low Stock
                    </span>
                    <span class="text-slate-400 dark:text-slate-500">
                        {{ $totalSkus }} SKUs
                    </span>
                </div>
            </div>

        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 my-4">
            
            <!-- Revenue vs Purchase Chart (2/3 width) -->
            <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-sm p-6 rounded-2xl lg:col-span-2">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="font-bold text-slate-800 dark:text-white text-lg">Financial Performance</h3>
                        <p class="text-xs text-slate-400 dark:text-slate-500">Comparing Sales Revenue and Purchase Costs for the past 7 days</p>
                    </div>
                    <div class="flex items-center gap-4 text-xs font-semibold">
                        <button type="button" id="toggle-sales-dataset" class="flex items-center gap-1.5 text-indigo-600 dark:text-indigo-400 hover:opacity-80 transition-all cursor-pointer">
                            <span class="w-2.5 h-2.5 rounded-full bg-indigo-600"></span> Sales
                        </button>
                        <button type="button" id="toggle-purchases-dataset" class="flex items-center gap-1.5 text-sky-500 dark:text-sky-400 hover:opacity-80 transition-all cursor-pointer">
                            <span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span> Purchases
                        </button>
                    </div>
                </div>
                <div class="h-[320px] relative">
                    <canvas id="revenue-analytics-chart"></canvas>
                </div>
            </div>

            <!-- Stock Health Breakdown (1/3 width) -->
            <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-sm p-6 rounded-2xl">
                <h3 class="font-bold text-slate-800 dark:text-white text-lg mb-1">Stock Health</h3>
                <p class="text-xs text-slate-400 dark:text-slate-500 mb-6">Inventory status summary analysis</p>
                
                <div class="space-y-4">
                    <!-- Progress Bar 1 -->
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-slate-600 dark:text-slate-400 font-medium">Healthy Stock Items</span>
                            <span class="font-bold text-slate-800 dark:text-white">
                                {{ $totalSkus > 0 ? round((($totalSkus - ($lowStockCount + $outOfStockCount)) / $totalSkus) * 100) : 100 }}%
                            </span>
                        </div>
                        <div class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full transition-all duration-500" style="width: {{ $totalSkus > 0 ? (($totalSkus - ($lowStockCount + $outOfStockCount)) / $totalSkus) * 100 : 100 }}%"></div>
                        </div>
                    </div>

                    <!-- Progress Bar 2 -->
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-slate-600 dark:text-slate-400 font-medium">Low Stock Warning</span>
                            <span class="font-bold text-slate-800 dark:text-white">
                                {{ $totalSkus > 0 ? round(($lowStockCount / $totalSkus) * 100) : 0 }}%
                            </span>
                        </div>
                        <div class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                            <div class="h-full bg-amber-500 rounded-full transition-all duration-500" style="width: {{ $totalSkus > 0 ? ($lowStockCount / $totalSkus) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <!-- Progress Bar 3 -->
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-slate-600 dark:text-slate-400 font-medium">Out of Stock</span>
                            <span class="font-bold text-slate-800 dark:text-white">
                                {{ $totalSkus > 0 ? round(($outOfStockCount / $totalSkus) * 100) : 0 }}%
                            </span>
                        </div>
                        <div class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                            <div class="h-full bg-rose-500 rounded-full transition-all duration-500" style="width: {{ $totalSkus > 0 ? ($outOfStockCount / $totalSkus) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-800 grid grid-cols-2 gap-4">
                    <div class="rounded-xl bg-slate-50 dark:bg-slate-800/50 p-4 text-center">
                        <div class="text-2xl font-bold text-slate-800 dark:text-white">{{ $lowStockCount }}</div>
                        <div class="text-xs text-slate-400 mt-1">Low Stock Items</div>
                    </div>
                    <div class="rounded-xl bg-slate-50 dark:bg-slate-800/50 p-4 text-center">
                        <div class="text-2xl font-bold text-slate-800 dark:text-white">{{ $outOfStockCount }}</div>
                        <div class="text-xs text-slate-400 mt-1">Out of Stock Items</div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Lists Section: Inventory lists & Activities -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Tabbed Inventory Monitor Card -->
            <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-sm p-6 rounded-2xl">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 space-y-3 sm:space-y-0">
                    <h3 class="font-bold text-slate-800 dark:text-white text-lg">Inventory Monitor</h3>
                    <div class="flex items-center space-x-1 bg-slate-100 dark:bg-slate-800 p-1 rounded-xl">
                        <button type="button" data-tab="inventory-tabs" data-tab-page="low-stock"
                            class="text-xs font-semibold py-1.5 px-3 rounded-lg text-slate-600 dark:text-slate-300 hover:text-slate-800 transition-all active">
                            Low Stock
                        </button>
                        <button type="button" data-tab="inventory-tabs" data-tab-page="out-of-stock"
                            class="text-xs font-semibold py-1.5 px-3 rounded-lg text-slate-600 dark:text-slate-300 hover:text-slate-800 transition-all">
                            Out of Stock
                        </button>
                        <button type="button" data-tab="inventory-tabs" data-tab-page="overstock"
                            class="text-xs font-semibold py-1.5 px-3 rounded-lg text-slate-600 dark:text-slate-300 hover:text-slate-800 transition-all">
                            Top Inventory
                        </button>
                    </div>
                </div>

                <!-- Low Stock Tab Content -->
                <div class="overflow-x-auto" data-tab-for="inventory-tabs" data-page="low-stock">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 dark:border-slate-800">
                                <th class="text-xs uppercase text-slate-400 font-semibold py-3 px-2">Item</th>
                                <th class="text-xs uppercase text-slate-400 font-semibold py-3 px-2">SKU</th>
                                <th class="text-xs uppercase text-slate-400 font-semibold py-3 px-2">Quantity</th>
                                <th class="text-xs uppercase text-slate-400 font-semibold py-3 px-2 text-right">Reorder Level</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse($lowStockItems as $item)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/35 transition-colors">
                                    <td class="py-3 px-2 flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 font-semibold">
                                            @if($item->image)
                                                <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-cover rounded-lg">
                                            @else
                                                {{ substr($item->name, 0, 1) }}
                                            @endif
                                        </div>
                                        <span class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ $item->name }}</span>
                                    </td>
                                    <td class="py-3 px-2 text-sm text-slate-500">{{ $item->sku }}</td>
                                    <td class="py-3 px-2 text-sm font-medium text-amber-500">{{ $item->stock_quantity }} units</td>
                                    <td class="py-3 px-2 text-sm text-slate-500 text-right">{{ $item->reorder_level }} units</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-sm text-slate-400">No low stock items found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Out of Stock Tab Content -->
                <div class="overflow-x-auto hidden" data-tab-for="inventory-tabs" data-page="out-of-stock">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 dark:border-slate-800">
                                <th class="text-xs uppercase text-slate-400 font-semibold py-3 px-2">Item</th>
                                <th class="text-xs uppercase text-slate-400 font-semibold py-3 px-2">SKU</th>
                                <th class="text-xs uppercase text-slate-400 font-semibold py-3 px-2">Quantity</th>
                                <th class="text-xs uppercase text-slate-400 font-semibold py-3 px-2 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse($outOfStockItems as $item)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/35 transition-colors">
                                    <td class="py-3 px-2 flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 font-semibold">
                                            @if($item->image)
                                                <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-cover rounded-lg">
                                            @else
                                                {{ substr($item->name, 0, 1) }}
                                            @endif
                                        </div>
                                        <span class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ $item->name }}</span>
                                    </td>
                                    <td class="py-3 px-2 text-sm text-slate-500">{{ $item->sku }}</td>
                                    <td class="py-3 px-2 text-sm font-medium text-rose-500">{{ $item->stock_quantity }} units</td>
                                    <td class="py-3 px-2 text-sm text-right">
                                        <a href="{{ route('purchases.create') }}" class="inline-flex items-center text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                                            Order Stock
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-sm text-slate-400">All items are currently in stock!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Overstock Tab Content -->
                <div class="overflow-x-auto hidden" data-tab-for="inventory-tabs" data-page="overstock">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 dark:border-slate-800">
                                <th class="text-xs uppercase text-slate-400 font-semibold py-3 px-2">Item</th>
                                <th class="text-xs uppercase text-slate-400 font-semibold py-3 px-2">SKU</th>
                                <th class="text-xs uppercase text-slate-400 font-semibold py-3 px-2">Quantity</th>
                                <th class="text-xs uppercase text-slate-400 font-semibold py-3 px-2 text-right">Selling Price</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse($overStockItems as $item)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/35 transition-colors">
                                    <td class="py-3 px-2 flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 font-semibold">
                                            @if($item->image)
                                                <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-cover rounded-lg">
                                            @else
                                                {{ substr($item->name, 0, 1) }}
                                            @endif
                                        </div>
                                        <span class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ $item->name }}</span>
                                    </td>
                                    <td class="py-3 px-2 text-sm text-slate-500">{{ $item->sku }}</td>
                                    <td class="py-3 px-2 text-sm font-medium text-emerald-500">{{ $item->stock_quantity }} units</td>
                                    <td class="py-3 px-2 text-sm text-slate-500 text-right">${{ number_format($item->selling_price, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-sm text-slate-400">No stock records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

            <!-- Recent Activity Timeline / Stock Movement -->
            <div class="bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 shadow-sm p-6 rounded-2xl flex flex-col">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-slate-800 dark:text-white text-lg">System Feed</h3>
                    <div class="flex items-center space-x-1 bg-slate-100 dark:bg-slate-800 p-1 rounded-xl">
                        <button type="button" data-tab="feed-tabs" data-tab-page="stock"
                            class="text-xs font-semibold py-1.5 px-3 rounded-lg text-slate-600 dark:text-slate-300 hover:text-slate-800 transition-all active">
                            Stock Feed
                        </button>
                        <button type="button" data-tab="feed-tabs" data-tab-page="activity"
                            class="text-xs font-semibold py-1.5 px-3 rounded-lg text-slate-600 dark:text-slate-300 hover:text-slate-800 transition-all">
                            User Logs
                        </button>
                    </div>
                </div>

                <!-- Stock Feed -->
                <div class="flex-1 overflow-y-auto max-h-[360px] pr-2 space-y-4" data-tab-for="feed-tabs" data-page="stock">
                    @forelse($stockMovements as $move)
                        <div class="flex items-start gap-4 p-3 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                            <div class="p-2 rounded-lg {{ $move->type == 'in' ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'bg-rose-500/10 text-rose-600 dark:text-rose-400' }}">
                                <i class="{{ $move->type == 'in' ? 'ri-arrow-left-down-line' : 'ri-arrow-right-up-line' }} text-lg"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start gap-2">
                                    <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-200 truncate">{{ $move->item->name ?? 'Unknown Item' }}</h4>
                                    <span class="text-xs font-bold whitespace-nowrap {{ $move->type == 'in' ? 'text-emerald-500' : 'text-rose-500' }}">
                                        {{ $move->type == 'in' ? '+' : '-' }}{{ $move->quantity }} qty
                                    </span>
                                </div>
                                <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5 truncate">{{ $move->remarks ?? 'Stock transaction logged' }}</p>
                                <span class="text-[10px] text-slate-400 dark:text-slate-600 mt-1 block">By {{ $move->user->name ?? 'System' }} • {{ $move->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center text-sm text-slate-400">No stock movements logged yet.</div>
                    @endforelse
                </div>

                <!-- User Logs -->
                <div class="flex-1 overflow-y-auto max-h-[360px] pr-2 space-y-4 hidden" data-tab-for="feed-tabs" data-page="activity">
                    @forelse($recentActivities as $log)
                        <div class="flex items-start gap-4 p-3 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors">
                            <div class="p-2 rounded-lg bg-indigo-500/10 text-indigo-600 dark:text-indigo-400">
                                <i class="ri-user-line text-lg"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-start">
                                    <h4 class="text-sm font-semibold text-slate-800 dark:text-slate-200 truncate">{{ $log->user->name ?? 'Guest User' }}</h4>
                                    <span class="text-xs text-slate-400 whitespace-nowrap">{{ $log->created_at->diffForHumans() }}</span>
                                </div>
                                <span class="text-xs font-medium text-slate-600 dark:text-slate-400 mt-0.5 inline-block">{{ $log->action }}</span>
                                <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">{{ $log->description }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center text-sm text-slate-400">No recent activities logged yet.</div>
                    @endforelse
                </div>

            </div>

        </div>

    </div>

    @push('custom-scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Instantiating our Dynamic Chart.js
                const canvas = document.getElementById('revenue-analytics-chart');
                if (canvas) {
                    const ctx = canvas.getContext('2d');
                    
                    // Create beautiful gradients
                    const salesGradient = ctx.createLinearGradient(0, 0, 0, 300);
                    salesGradient.addColorStop(0, 'rgba(79, 70, 229, 0.3)');
                    salesGradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

                    const purchasesGradient = ctx.createLinearGradient(0, 0, 0, 300);
                    purchasesGradient.addColorStop(0, 'rgba(14, 165, 233, 0.3)');
                    purchasesGradient.addColorStop(1, 'rgba(14, 165, 233, 0)');

                    const chartInstance = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: @json($chartLabels),
                            datasets: [
                                {
                                    label: 'Sales Revenue ($)',
                                    data: @json($chartSales),
                                    borderColor: '#4f46e5',
                                    borderWidth: 3,
                                    backgroundColor: salesGradient,
                                    fill: true,
                                    tension: 0.4,
                                    pointBackgroundColor: '#4f46e5',
                                    pointBorderColor: '#ffffff',
                                    pointBorderWidth: 2,
                                    pointRadius: 4,
                                    pointHoverRadius: 6
                                },
                                {
                                    label: 'Purchases Cost ($)',
                                    data: @json($chartPurchases),
                                    borderColor: '#0ea5e9',
                                    borderWidth: 3,
                                    backgroundColor: purchasesGradient,
                                    fill: true,
                                    tension: 0.4,
                                    pointBackgroundColor: '#0ea5e9',
                                    pointBorderColor: '#ffffff',
                                    pointBorderWidth: 2,
                                    pointRadius: 4,
                                    pointHoverRadius: 6
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                                    titleColor: '#ffffff',
                                    bodyColor: '#ffffff',
                                    padding: 12,
                                    cornerRadius: 8,
                                    displayColors: true,
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.dataset.label || '';
                                            if (label) {
                                                label += ': ';
                                            }
                                            if (context.parsed.y !== null) {
                                                label += new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(context.parsed.y);
                                            }
                                            return label;
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        color: '#94a3b8',
                                        font: {
                                            family: 'Outfit, sans-serif',
                                            size: 11
                                        }
                                    }
                                },
                                y: {
                                    grid: {
                                        color: 'rgba(148, 163, 184, 0.1)',
                                        borderDash: [5, 5]
                                    },
                                    ticks: {
                                        color: '#94a3b8',
                                        font: {
                                            family: 'Outfit, sans-serif',
                                            size: 11
                                        },
                                        callback: function(value) {
                                            return '$' + value;
                                        }
                                    }
                                }
                            }
                        }
                    });

                    const salesBtn = document.getElementById('toggle-sales-dataset');
                    const purchasesBtn = document.getElementById('toggle-purchases-dataset');
                    
                    if (salesBtn) {
                        salesBtn.addEventListener('click', function() {
                            const isVisible = chartInstance.isDatasetVisible(0);
                            chartInstance.setDatasetVisibility(0, !isVisible);
                            chartInstance.update();
                            if (isVisible) {
                                salesBtn.classList.add('opacity-40', 'line-through');
                            } else {
                                salesBtn.classList.remove('opacity-40', 'line-through');
                            }
                        });
                    }
                    
                    if (purchasesBtn) {
                        purchasesBtn.addEventListener('click', function() {
                            const isVisible = chartInstance.isDatasetVisible(1);
                            chartInstance.setDatasetVisibility(1, !isVisible);
                            chartInstance.update();
                            if (isVisible) {
                                purchasesBtn.classList.add('opacity-40', 'line-through');
                            } else {
                                purchasesBtn.classList.remove('opacity-40', 'line-through');
                            }
                        });
                    }
                }

                // Handling Custom Tabs Logic in Dashboard
                const setupTabs = (tabGroupAttribute) => {
                    const triggers = document.querySelectorAll(`[data-tab="${tabGroupAttribute}"]`);
                    triggers.forEach(trigger => {
                        trigger.addEventListener('click', function () {
                            const page = this.getAttribute('data-tab-page');
                            
                            // Remove active from sibling triggers
                            triggers.forEach(t => t.classList.remove('active', 'bg-white', 'dark:bg-slate-900', 'shadow-sm'));
                            
                            // Add active styling
                            this.classList.add('active', 'bg-white', 'dark:bg-slate-900', 'shadow-sm');
                            
                            // Hide all target content sections
                            document.querySelectorAll(`[data-tab-for="${tabGroupAttribute}"]`).forEach(container => {
                                container.classList.add('hidden');
                            });
                            
                            // Show target content section
                            const target = document.querySelector(`[data-tab-for="${tabGroupAttribute}"][data-page="${page}"]`);
                            if (target) {
                                target.classList.remove('hidden');
                            }
                        });
                    });
                    
                    // Initialize first tab styles
                    const firstActive = document.querySelector(`[data-tab="${tabGroupAttribute}"].active`);
                    if (firstActive) {
                        firstActive.classList.add('bg-white', 'dark:bg-slate-900', 'shadow-sm');
                    }
                };

                setupTabs('inventory-tabs');
                setupTabs('feed-tabs');
            });
        </script>
    @endpush
</x-app-layout>
