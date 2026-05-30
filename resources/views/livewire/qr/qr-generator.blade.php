<div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="{ qrData: '', qrSize: 200, qrColor: '#1e3a8a', initQr() { if (this.qrData) { new QRious({ element: document.getElementById('qr-canvas'), value: this.qrData, size: this.qrSize, foreground: this.qrColor }); } } }">
    <!-- Left Column (2 cols): Items List -->
    <div class="lg:col-span-2 bg-white p-6 rounded-1xl border border-slate-200 shadow-sm">
        <div class="mb-4">
            <h3 class="font-bold text-slate-800 text-[15px] mb-3">Select Product to Generate QR Code</h3>
            <div class="relative max-w-xs">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search item, SKU or barcode..."
                    class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition" />
                <div class="absolute left-3.5 top-2.5 text-slate-400"><i class="fa-solid fa-search text-sm"></i></div>
            </div>
        </div>

        <div class="overflow-x-auto mt-4">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-xs uppercase font-semibold">
                        <th class="px-4 py-3">Product Name</th>
                        <th class="px-4 py-3">SKU</th>
                        <th class="px-4 py-3">Price</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                    @forelse ($items as $item)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-4 py-4 font-bold text-slate-900">{{ $item->name }}</td>
                            <td class="px-4 py-4 text-slate-500">{{ $item->sku }}</td>
                            <td class="px-4 py-4 font-semibold text-slate-700">${{ number_format($item->selling_price, 2) }}</td>
                            <td class="px-4 py-4 text-center">
                                <button type="button" wire:click="selectItem({{ $item->id }})" x-on:click="qrData = '{{ $item->sku }}'; setTimeout(() => { initQr(); }, 150);" class="px-3 py-1 bg-blue-600 text-white rounded text-[11px] font-semibold hover:bg-blue-700 transition">
                                    Select
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="px-4 py-8 text-center text-slate-400">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $items->links() }}
        </div>
    </div>

    <!-- Right Column (1 col): Generator Preview Panel -->
    <div class="bg-white p-6 rounded-1xl border border-slate-200 shadow-sm space-y-6">
        <h3 class="font-bold text-slate-800 text-[15px] pb-2 border-b border-slate-100">QR Code Preview</h3>

        @if ($selectedItem)
            <div class="flex flex-col items-center justify-center p-6 bg-slate-50 rounded-lg border border-slate-100 shadow-inner">
                <!-- Printable Tag Design -->
                <div id="printable-qr-tag" class="bg-white p-4 rounded border border-slate-200 flex flex-col items-center justify-center text-center max-w-[260px] shadow-sm">
                    <span class="text-[11px] font-bold text-slate-800 tracking-wide uppercase">{{ $selectedItem['name'] }}</span>
                    <span class="text-[9px] text-slate-400 font-semibold mb-3">SKU: {{ $selectedItem['sku'] }}</span>
                    
                    <canvas id="qr-canvas" class="my-2"></canvas>

                    <div class="text-[12px] font-extrabold text-blue-600 mt-2">${{ number_format($selectedItem['selling_price'], 2) }}</div>
                </div>
            </div>

            <!-- Interactivity settings -->
            <div class="space-y-4 text-xs">
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">QR Value (SKU/Code):</label>
                    <input type="text" x-model="qrData" x-on:input="initQr()" class="w-full px-3 py-2 border border-slate-200 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Size (px):</label>
                    <select x-model="qrSize" x-on:change="initQr()" class="w-full px-3 py-2 border border-slate-200 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="150">150 x 150</option>
                        <option value="200">200 x 200</option>
                        <option value="250">250 x 250</option>
                        <option value="300">300 x 300</option>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Theme Color:</label>
                    <select x-model="qrColor" x-on:change="initQr()" class="w-full px-3 py-2 border border-slate-200 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="#1e3a8a">Navy Blue</option>
                        <option value="#000000">Classic Black</option>
                        <option value="#047857">Emerald Green</option>
                        <option value="#b91c1c">Crimson Red</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-2">
                <button type="button" onclick="printQrTag()" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded text-xs font-semibold hover:bg-blue-700 transition flex items-center justify-center gap-1">
                    <i class="fa-solid fa-print"></i> Print Label
                </button>
                <button type="button" wire:click="clearSelection" class="px-4 py-2 bg-slate-100 text-slate-700 rounded text-xs font-semibold hover:bg-slate-200 transition">
                    Clear
                </button>
            </div>
        @else
            <div class="py-12 text-center text-slate-400 text-xs">
                Select a product from the list to preview and print its label.
            </div>
        @endif
    </div>

    <!-- Print styling script & libraries -->
    @push('custom-scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
        <script>
            function printQrTag() {
                var printContents = document.getElementById('printable-qr-tag').outerHTML;
                var originalContents = document.body.innerHTML;
                
                // Open printing window
                var popupWin = window.open('', '_blank', 'width=600,height=600');
                popupWin.document.open();
                popupWin.document.write(`
                    <html>
                        <head>
                            <title>Print Label</title>
                            <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
                            <style>
                                body {
                                    font-family: 'Inter', sans-serif;
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;
                                    height: 100vh;
                                    margin: 0;
                                }
                                .tag {
                                    padding: 20px;
                                    border: 1px solid #e2e8f0;
                                    border-radius: 8px;
                                    text-align: center;
                                    max-width: 260px;
                                    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
                                }
                                h1 { font-size: 14px; margin: 0; text-transform: uppercase; font-weight: 800; }
                                p { font-size: 10px; color: #94a3b8; margin: 5px 0 15px 0; }
                                .price { font-size: 15px; font-weight: 800; color: #2563eb; margin-top: 10px; }
                            </style>
                        </head>
                        <body onload="window.print(); window.close();">
                            <div class="tag">
                                ${printContents}
                            </div>
                        </body>
                    </html>
                `);
                popupWin.document.close();
            }
        </script>
    @endpush
</div>
