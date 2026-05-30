<div class="space-y-6">
    <!-- Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-indigo-500 to-blue-600 p-6 rounded-1xl border border-indigo-100 shadow-sm text-white relative overflow-hidden">
            <div class="absolute right-4 bottom-4 text-white/10 text-6xl"><i class="fa-solid fa-boxes"></i></div>
            <span class="text-xs uppercase font-bold text-white/85 tracking-wider">Total Unique Products</span>
            <div class="text-3xl font-extrabold mt-2">{{ $totalItems }}</div>
        </div>

        <div class="bg-white p-6 rounded-1xl border border-slate-200 shadow-sm relative overflow-hidden">
            <div class="absolute right-4 bottom-4 text-emerald-500/10 text-6xl"><i class="fa-solid fa-calculator"></i></div>
            <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Total Inventory Cost Value</span>
            <div class="text-3xl font-extrabold text-slate-800 mt-2">${{ number_format($totalStockValuation, 2) }}</div>
        </div>

        <div class="bg-white p-6 rounded-1xl border border-slate-200 shadow-sm relative overflow-hidden">
            <div class="absolute right-4 bottom-4 text-blue-500/10 text-6xl"><i class="fa-solid fa-file-invoice-dollar"></i></div>
            <span class="text-xs uppercase font-bold text-slate-400 tracking-wider">Estimated Retail Value</span>
            <div class="text-3xl font-extrabold text-slate-800 mt-2">${{ number_format($totalRetailValuation, 2) }}</div>
        </div>
    </div>

    <!-- Filter and Search -->
    <div class="bg-white p-6 rounded-1xl border border-slate-200 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="relative max-w-xs flex-1">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search item or SKU..."
                    class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                <div class="absolute left-3.5 top-2.5 text-slate-400"><i class="fa-solid fa-search text-sm"></i></div>
            </div>

            <div class="flex items-center gap-3">
                <label class="text-xs font-semibold text-slate-600">Store Filter:</label>
                <x-select wire:model.live="selectedStore" class="text-xs py-1.5 min-w-[200px]">
                    <option value="">All Stores</option>
                    @foreach ($stores as $st)
                        <option value="{{ $st->id }}">{{ $st->name }}</option>
                    @endforeach
                </x-select>
            </div>
        </div>

        <!-- Table -->
        <div class="mt-6 overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-xs uppercase font-semibold">
                        <th class="px-4 py-3">Product</th>
                        <th class="px-4 py-3">SKU</th>
                        <th class="px-4 py-3 text-center">Category</th>
                        @if (!$selectedStore)
                            <th class="px-4 py-3 text-center">Store Breakdown</th>
                        @endif
                        <th class="px-4 py-3 text-right">In-Stock Qty</th>
                        <th class="px-4 py-3 text-right">Retail Price</th>
                        <th class="px-4 py-3 text-right">Total Valuation</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse ($items as $item)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-4 py-4 font-bold text-slate-900">{{ $item->name }}</td>
                            <td class="px-4 py-4 text-slate-500">{{ $item->sku }}</td>
                            <td class="px-4 py-4 text-center">{{ $item->category->name ?? 'N/A' }}</td>
                            @if (!$selectedStore)
                                <td class="px-4 py-4">
                                    <div class="flex flex-col gap-1 text-[10px] text-slate-500">
                                        @foreach ($item->storeItems as $si)
                                            <span class="block">{{ $si->store->name }}: <strong class="text-slate-700">{{ $si->stock_quantity }}</strong></span>
                                        @endforeach
                                    </div>
                                </td>
                            @endif
                            <td class="px-4 py-4 text-right font-semibold">
                                @php
                                    $qty = $selectedStore 
                                        ? ($item->storeItems->where('store_id', $selectedStore)->first()->stock_quantity ?? 0) 
                                        : $item->stock_quantity;
                                @endphp
                                <span class="{{ $qty <= $item->reorder_level ? 'text-red-500' : 'text-slate-800' }}">
                                    {{ $qty }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-right">${{ number_format($item->selling_price, 2) }}</td>
                            <td class="px-4 py-4 text-right font-bold text-slate-900">${{ number_format($qty * $item->selling_price, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="px-4 py-12 text-center text-slate-400">No stock records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $items->links() }}
        </div>
    </div>
</div>
