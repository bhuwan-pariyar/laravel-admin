<div class="py-2" id="printable-area">
    <div class="bg-white dark:bg-slate-900 p-8 rounded-1xl border border-slate-200 dark:border-slate-800 shadow-sm max-w-4xl mx-auto text-slate-800 dark:text-slate-200">
        <!-- Invoice Header -->
        <div class="flex flex-col md:flex-row md:justify-between items-start md:items-center pb-8 border-b border-slate-100 dark:border-slate-800/80 gap-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100 tracking-tight">INVOICE</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Invoice Number: <strong class="text-slate-800 dark:text-slate-200">{{ $sale->invoice_no }}</strong></p>
                <p class="text-xs text-slate-500 dark:text-slate-400">Date: <strong class="text-slate-800 dark:text-slate-200">{{ $sale->sale_date->format('Y-m-d') }}</strong></p>
            </div>
            <div class="text-right">
                <div class="text-lg font-bold text-blue-600 dark:text-blue-400">INVENTORY PORTAL</div>
                <p class="text-xs text-slate-500 dark:text-slate-400">Store: <strong class="text-slate-800 dark:text-slate-200">{{ $sale->store->name }}</strong></p>
                <p class="text-xs text-slate-500 dark:text-slate-400">Location: <strong class="text-slate-800 dark:text-slate-200">{{ $sale->store->location }}</strong></p>
            </div>
        </div>

        <!-- Billing Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 py-8 border-b border-slate-100 dark:border-slate-800/80">
            <div>
                <span class="text-[10px] uppercase font-bold text-slate-400 dark:text-slate-500 tracking-wider">Billed To</span>
                <div class="text-slate-800 dark:text-slate-100 font-bold mt-1.5">{{ $sale->customer->name }}</div>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1"><i class="fa-solid fa-envelope mr-1 text-slate-400 dark:text-slate-500"></i> {{ $sale->customer->email }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400"><i class="fa-solid fa-phone mr-1 text-slate-400 dark:text-slate-500"></i> {{ $sale->customer->phone }}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400"><i class="fa-solid fa-location-dot mr-1.5 text-slate-400 dark:text-slate-500"></i> {{ $sale->customer->address }}</p>
            </div>
            <div class="md:text-right">
                <span class="text-[10px] uppercase font-bold text-slate-400 dark:text-slate-500 tracking-wider">Payment Status</span>
                <div class="mt-2">
                    @php
                        $colors = [
                            'paid' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-400',
                            'pending' => 'bg-rose-100 text-rose-800 dark:bg-rose-950/40 dark:text-rose-400',
                            'partial' => 'bg-amber-100 text-amber-800 dark:bg-amber-950/40 dark:text-amber-400'
                        ];
                    @endphp
                    <span class="px-3 py-1 text-xs font-bold rounded-full {{ $colors[strtolower($sale->payment_status)] ?? 'bg-slate-100 dark:bg-slate-800' }}">
                        {{ strtoupper($sale->payment_status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Line Items Table -->
        <div class="py-8">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/40 border-b border-slate-100 dark:border-slate-800/60">
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase">Item Name</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase text-center w-24">Price</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase text-center w-24">Quantity</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase text-right w-32">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/40">
                    @foreach ($sale->items as $item)
                        <tr>
                            <td class="px-4 py-4 text-xs font-medium text-slate-800 dark:text-slate-200">
                                {{ $item->item->name }}
                                <span class="block text-[10px] text-slate-400 dark:text-slate-500 mt-0.5">SKU: {{ $item->item->sku }}</span>
                            </td>
                            <td class="px-4 py-4 text-xs text-slate-600 dark:text-slate-400 text-center">${{ number_format($item->selling_price, 2) }}</td>
                            <td class="px-4 py-4 text-xs text-slate-600 dark:text-slate-400 text-center">{{ $item->quantity }}</td>
                            <td class="px-4 py-4 text-xs text-slate-800 dark:text-slate-200 font-semibold text-right">${{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Calculation details -->
        <div class="flex flex-col md:flex-row md:justify-between items-start pt-6 border-t border-slate-100 dark:border-slate-800/80 gap-6">
            <div class="text-xs text-slate-500 dark:text-slate-400 max-w-sm">
                @if ($sale->remarks)
                    <strong class="text-slate-700 dark:text-slate-300 block mb-1">Remarks:</strong>
                    {{ $sale->remarks }}
                @endif
            </div>
            <div class="w-full md:w-72 space-y-2.5">
                @php
                    $sub = $sale->items->sum('total');
                    $tax_calc = $sale->tax_amount;
                @endphp
                <div class="flex justify-between text-xs text-slate-600 dark:text-slate-400">
                    <span>Subtotal:</span>
                    <span>${{ number_format($sub, 2) }}</span>
                </div>
                @if ($tax_calc > 0)
                    <div class="flex justify-between text-xs text-slate-600 dark:text-slate-400">
                        <span>Tax Amount:</span>
                        <span>${{ number_format($tax_calc, 2) }}</span>
                    </div>
                @endif
                @if ($sale->discount_amount > 0)
                    <div class="flex justify-between text-xs text-slate-600 dark:text-slate-400">
                        <span>Discount:</span>
                        <span class="text-emerald-600 dark:text-emerald-400">-${{ number_format($sale->discount_amount, 2) }}</span>
                    </div>
                @endif
                <div class="flex justify-between text-sm font-bold text-slate-800 dark:text-slate-200 pt-2 border-t border-slate-100 dark:border-slate-800">
                    <span>Grand Total:</span>
                    <span class="text-blue-600 dark:text-blue-400 text-base">${{ number_format($sale->grand_total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3 mt-10 pt-6 border-t border-slate-100 dark:border-slate-800 print:hidden">
            <a href="{{ route('sales.list') }}" class="px-4 py-2 text-xs font-medium text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 rounded hover:bg-slate-200 dark:hover:bg-slate-700 transition">Back to List</a>
            <button onclick="window.print()" class="px-4 py-2 text-xs font-medium text-white bg-blue-600 rounded hover:bg-blue-700 transition flex items-center gap-1.5 shadow-sm">
                <i class="fa-solid fa-print"></i> Print Invoice
            </button>
        </div>
    </div>
</div>
