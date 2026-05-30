<div class="py-2" id="printable-area">
    <div class="bg-white dark:bg-slate-900 p-8 rounded-1xl border border-slate-200 dark:border-slate-800 shadow-sm max-w-4xl mx-auto text-slate-800 dark:text-slate-200">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:justify-between items-start md:items-center pb-8 border-b border-slate-100 dark:border-slate-800/80 gap-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100 tracking-tight">STOCK TRANSFER REPORT</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Transfer Number: <strong class="text-slate-800 dark:text-slate-200">{{ $transfer->transfer_no }}</strong></p>
                <p class="text-xs text-slate-500 dark:text-slate-400">Date: <strong class="text-slate-800 dark:text-slate-200">{{ $transfer->transfer_date->format('Y-m-d') }}</strong></p>
            </div>
            <div class="text-right">
                <div class="text-lg font-bold text-blue-600 dark:text-blue-400">INVENTORY PORTAL</div>
                <p class="text-xs text-slate-500 dark:text-slate-400">Created By: <strong class="text-slate-800 dark:text-slate-200">{{ $transfer->creator->name }}</strong></p>
            </div>
        </div>

        <!-- Store Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 py-8 border-b border-slate-100 dark:border-slate-800/80">
            <div>
                <span class="text-[10px] uppercase font-bold text-slate-400 dark:text-slate-500 tracking-wider">Source (From)</span>
                <div class="text-slate-800 dark:text-slate-100 font-bold mt-1.5">{{ $transfer->fromStore->name }}</div>
                <p class="text-xs text-slate-500 dark:text-slate-400"><i class="fa-solid fa-location-dot mr-1.5 text-slate-400 dark:text-slate-500"></i> {{ $transfer->fromStore->location }}</p>
            </div>
            <div class="md:text-right">
                <span class="text-[10px] uppercase font-bold text-slate-400 dark:text-slate-500 tracking-wider">Destination (To)</span>
                <div class="text-slate-800 dark:text-slate-100 font-bold mt-1.5">{{ $transfer->toStore->name }}</div>
                <p class="text-xs text-slate-500 dark:text-slate-400"><i class="fa-solid fa-location-dot mr-1.5 text-slate-400 dark:text-slate-500"></i> {{ $transfer->toStore->location }}</p>
            </div>
        </div>

        <!-- Line Items Table -->
        <div class="py-8">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/40 border-b border-slate-100 dark:border-slate-800/60">
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase">Item Name</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase">SKU</th>
                        <th class="px-4 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase text-right w-32">Quantity Transferred</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/40">
                    @foreach ($transfer->items as $item)
                        <tr>
                            <td class="px-4 py-4 text-xs font-medium text-slate-800 dark:text-slate-200">{{ $item->item->name }}</td>
                            <td class="px-4 py-4 text-xs text-slate-600 dark:text-slate-400">{{ $item->item->sku }}</td>
                            <td class="px-4 py-4 text-xs text-slate-850 dark:text-slate-300 font-semibold text-right">{{ $item->quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Note details -->
        <div class="flex flex-col md:flex-row md:justify-between items-start pt-6 border-t border-slate-100 dark:border-slate-800/80 gap-6">
            <div class="text-xs text-slate-500 dark:text-slate-400 max-w-sm">
                @if ($transfer->remarks)
                    <strong class="text-slate-700 dark:text-slate-300 block mb-1">Remarks / Note:</strong>
                    {{ $transfer->remarks }}
                @endif
            </div>
            <div class="w-full md:w-72 space-y-2.5">
                <div class="flex justify-between text-xs text-slate-600 dark:text-slate-400">
                    <span>Status:</span>
                    <span class="px-2.5 py-0.5 text-[10px] font-bold rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-400">
                        {{ strtoupper($transfer->status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3 mt-10 pt-6 border-t border-slate-100 dark:border-slate-800 print:hidden">
            <a href="{{ route('transfers.list') }}" class="px-4 py-2 text-xs font-medium text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 rounded hover:bg-slate-200 dark:hover:bg-slate-700 transition">Back to List</a>
            <button onclick="window.print()" class="px-4 py-2 text-xs font-medium text-white bg-blue-600 rounded hover:bg-blue-700 transition flex items-center gap-1.5 shadow-sm">
                <i class="fa-solid fa-print"></i> Print Receipt
            </button>
        </div>
    </div>
</div>
