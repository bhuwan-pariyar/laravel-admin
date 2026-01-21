<div class="p-6">
    <!-- Item Header -->
    <div class="flex items-center gap-4 pb-4 border-b border-slate-200">
        @if ($item->image)
            <img src="{{ asset('storage/' . $item->image) }}" alt="Item Image"
                class="w-16 h-16 rounded-lg shadow-lg object-cover">
        @else
            <div
                class="w-16 h-16 rounded-lg bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center shadow-lg">
                <i class="fa-solid fa-box text-white text-2xl"></i>
            </div>
        @endif
        <div class="flex-1">
            <h3 class="text-xl font-bold text-slate-900">{{ $item->name }}</h3>
            <p class="text-sm text-slate-500">SKU: {{ $item->sku }}</p>
        </div>
        <div>
            @php
                $statusColors = [
                    'active' => 'bg-green-100 text-green-800 border-green-200',
                    'inactive' => 'bg-slate-100 text-slate-800 border-slate-200',
                ];
                $status = $item->status == '1' ? 'active' : 'inactive';
            @endphp
            <span class="px-3 py-0.5 text-xs font-semibold rounded-full border {{ $statusColors[$status] }}">
                {{ ucfirst($status) }}
            </span>
        </div>
    </div>

    <!-- Item Details -->
    <div class="mt-6 space-y-4">
        <!-- ID -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                <span class="text-sm font-medium text-slate-600">Item ID</span>
            </div>
            <span class="text-sm font-semibold text-slate-900">#{{ $item->id }}</span>
        </div>

        <!-- SKU -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                </svg>
                <span class="text-sm font-medium text-slate-600">SKU</span>
            </div>
            <span class="text-sm text-slate-900 font-mono bg-slate-50 px-2 py-1 rounded">{{ $item->sku }}</span>
        </div>

        <!-- Barcode -->
        @if ($item->barcode)
            <div class="flex items-center justify-between py-3 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="text-sm font-medium text-slate-600">Barcode</span>
                </div>
                <span class="text-sm text-slate-900 font-mono">{{ $item->barcode }}</span>
            </div>
        @endif

        <!-- Category -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                </svg>
                <span class="text-sm font-medium text-slate-600">Category</span>
            </div>
            <a href="{{ route('categories.show', $item->category->id) }}" class="text-sm text-blue-600 hover:underline">
                {{ $item->category->name }}
            </a>
        </div>

        <!-- Description -->
        @if ($item->description)
            <div class="py-3 border-b border-slate-100">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                    <span class="text-sm font-medium text-slate-600">Description</span>
                </div>
                <p class="text-sm text-slate-700 ml-7">{{ $item->description }}</p>
            </div>
        @endif

        <!-- Pricing Section -->
        <div
            class="grid grid-cols-3 gap-4 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 px-4 rounded-lg border border-blue-100 my-4">
            <div>
                <p class="text-xs text-slate-600 mb-1">Cost Price</p>
                <p class="text-lg font-bold text-slate-900">${{ number_format($item->cost_price, 2) }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-600 mb-1">Selling Price</p>
                <p class="text-lg font-bold text-slate-900">${{ number_format($item->selling_price, 2) }}</p>
            </div>
            <div>
                <p class="text-xs text-slate-600 mb-1">Profit per Unit</p>
                @php $profit = $item->selling_price - $item->cost_price; @endphp
                <p class="text-lg font-bold {{ $profit > 0 ? 'text-green-600' : 'text-red-600' }}">
                    ${{ number_format($profit, 2) }}
                </p>
            </div>
        </div>

        <!-- Stock Section -->
        <div
            class="grid grid-cols-3 gap-4 py-4 bg-gradient-to-r from-amber-50 to-orange-50 px-4 rounded-lg border border-amber-100">
            <div>
                <p class="text-xs text-slate-600 mb-1">Current Stock</p>
                <p class="text-lg font-bold text-slate-900">{{ $item->stock_quantity }} units</p>
            </div>
            <div>
                <p class="text-xs text-slate-600 mb-1">Reorder Level</p>
                <p class="text-lg font-bold text-slate-900">{{ $item->reorder_level }} units</p>
            </div>
            <div>
                <p class="text-xs text-slate-600 mb-1">Status</p>
                @if ($item->isLowStock())
                    <p class="text-sm font-bold text-red-600">⚠️ Low Stock</p>
                @else
                    <p class="text-sm font-bold text-green-600">✓ In Stock</p>
                @endif
            </div>
        </div>

        <!-- Profit Margin -->
        <div class="flex items-center justify-between py-3 border-b border-slate-100">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                <span class="text-sm font-medium text-slate-600">Profit Margin</span>
            </div>
            @php $margin = $item->cost_price > 0 ? (($item->selling_price - $item->cost_price) / $item->cost_price) * 100 : 0; @endphp
            <span class="text-sm font-semibold {{ $margin > 0 ? 'text-green-600' : 'text-red-600' }}">
                {{ number_format($margin, 2) }}%
            </span>
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
                <p class="text-sm font-medium text-slate-900">{{ $item->created_at->format('M d, Y') }}</p>
                <p class="text-xs text-slate-500">{{ $item->created_at->format('h:i A') }}</p>
            </div>
        </div>

        <!-- Last Updated -->
        <div class="flex items-center justify-between py-3">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span class="text-sm font-medium text-slate-600">Last Updated</span>
            </div>
            <div class="text-right">
                <p class="text-sm font-medium text-slate-900">{{ $item->updated_at->format('M d, Y') }}</p>
                <p class="text-xs text-slate-500">{{ $item->updated_at->format('h:i A') }}</p>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-end gap-3 mt-6 pt-4 border-t border-slate-200">
        <a href="{{ route('items.list') }}"
            class="px-4 py-1 bg-slate-200 text-slate-700 rounded-sm text-sm font-medium hover:bg-slate-300 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>&nbsp;
            Back
        </a>
    </div>
</div>
