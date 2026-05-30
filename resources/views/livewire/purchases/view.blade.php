<div class="py-2" id="printable-area">
    <div class="bg-white p-8 rounded-1xl border border-slate-200 shadow-sm max-w-4xl mx-auto">
        <!-- Invoice Header -->
        <div class="flex flex-col md:flex-row md:justify-between items-start md:items-center pb-8 border-b border-slate-100 gap-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">PURCHASE ORDER</h2>
                <p class="text-xs text-slate-500 mt-1">Purchase Number: <strong class="text-slate-800">{{ $purchase->purchase_no }}</strong></p>
                <p class="text-xs text-slate-500">Date: <strong class="text-slate-800">{{ $purchase->purchase_date->format('Y-m-d') }}</strong></p>
            </div>
            <div class="text-right">
                <div class="text-lg font-bold text-blue-600">INVENTORY PORTAL</div>
                <p class="text-xs text-slate-500">Store: <strong class="text-slate-800">{{ $purchase->store->name }}</strong></p>
                <p class="text-xs text-slate-500">Location: <strong class="text-slate-800">{{ $purchase->store->location }}</strong></p>
            </div>
        </div>

        <!-- Supplier Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 py-8 border-b border-slate-100">
            <div>
                <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Supplier Details</span>
                <div class="text-slate-800 font-bold mt-1.5">{{ $purchase->supplier->name }}</div>
                <p class="text-xs text-slate-500 mt-1"><i class="fa-solid fa-envelope mr-1 text-slate-400"></i> {{ $purchase->supplier->email }}</p>
                <p class="text-xs text-slate-500"><i class="fa-solid fa-phone mr-1 text-slate-400"></i> {{ $purchase->supplier->phone }}</p>
                <p class="text-xs text-slate-500"><i class="fa-solid fa-location-dot mr-1.5 text-slate-400"></i> {{ $purchase->supplier->address }}</p>
            </div>
            <div class="md:text-right">
                <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Payment Status</span>
                <div class="mt-2">
                    @php
                        $colors = [
                            'paid' => 'bg-emerald-100 text-emerald-800',
                            'pending' => 'bg-rose-100 text-rose-800',
                            'partial' => 'bg-amber-100 text-amber-800'
                        ];
                    @endphp
                    <span class="px-3 py-1 text-xs font-bold rounded-full {{ $colors[strtolower($purchase->payment_status)] ?? 'bg-slate-100' }}">
                        {{ strtoupper($purchase->payment_status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Line Items Table -->
        <div class="py-8">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase">Item Name</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase text-center w-24">Cost</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase text-center w-24">Quantity</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 uppercase text-right w-32">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($purchase->items as $item)
                        <tr>
                            <td class="px-4 py-4 text-xs font-medium text-slate-800">
                                {{ $item->item->name }}
                                <span class="block text-[10px] text-slate-400 mt-0.5">SKU: {{ $item->item->sku }}</span>
                            </td>
                            <td class="px-4 py-4 text-xs text-slate-600 text-center">${{ number_format($item->cost_price, 2) }}</td>
                            <td class="px-4 py-4 text-xs text-slate-600 text-center">{{ $item->quantity }}</td>
                            <td class="px-4 py-4 text-xs text-slate-800 font-semibold text-right">${{ number_format($item->total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Calculation details -->
        <div class="flex flex-col md:flex-row md:justify-between items-start pt-6 border-t border-slate-100 gap-6">
            <div class="text-xs text-slate-500 max-w-sm">
                @if ($purchase->remarks)
                    <strong class="text-slate-700 block mb-1">Remarks:</strong>
                    {{ $purchase->remarks }}
                @endif
            </div>
            <div class="w-full md:w-72 space-y-2.5">
                @php
                    $sub = $purchase->items->sum('total');
                    $tax_calc = $purchase->tax_amount;
                @endphp
                <div class="flex justify-between text-xs text-slate-600">
                    <span>Subtotal:</span>
                    <span>${{ number_format($sub, 2) }}</span>
                </div>
                @if ($tax_calc > 0)
                    <div class="flex justify-between text-xs text-slate-600">
                        <span>Tax Amount:</span>
                        <span>${{ number_format($tax_calc, 2) }}</span>
                    </div>
                @endif
                @if ($purchase->discount_amount > 0)
                    <div class="flex justify-between text-xs text-slate-600">
                        <span>Discount:</span>
                        <span class="text-emerald-600">-${{ number_format($purchase->discount_amount, 2) }}</span>
                    </div>
                @endif
                <div class="flex justify-between text-sm font-bold text-slate-800 pt-2 border-t border-slate-100">
                    <span>Grand Total:</span>
                    <span class="text-blue-600 text-base">${{ number_format($purchase->grand_total, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3 mt-10 pt-6 border-t border-slate-100 print:hidden">
            <a href="{{ route('purchases.list') }}" class="px-4 py-2 text-xs font-medium text-slate-700 bg-slate-100 rounded hover:bg-slate-200 transition">Back to List</a>
            <button onclick="window.print()" class="px-4 py-2 text-xs font-medium text-white bg-blue-600 rounded hover:bg-blue-700 transition flex items-center gap-1.5 shadow-sm">
                <i class="fa-solid fa-print"></i> Print Details
            </button>
        </div>
    </div>
</div>
