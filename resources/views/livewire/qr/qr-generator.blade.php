<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column: Items List -->
    <div class="lg:col-span-2 bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="mb-4">
            <h3 class="font-bold text-slate-800 dark:text-slate-100 text-[15px] mb-3">Select Product to Generate QR Code</h3>
            <div class="relative max-w-xs">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search item, SKU or barcode..."
                    class="w-full pl-10 pr-4 py-2 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-lg text-sm text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" />
                <div class="absolute left-3.5 top-2.5 text-slate-400 dark:text-slate-500"><i class="fa-solid fa-search text-sm"></i></div>
            </div>
        </div>

        <div class="overflow-x-auto mt-4">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/60 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 text-xs uppercase font-semibold">
                        <th class="px-4 py-3">Product Name</th>
                        <th class="px-4 py-3">SKU</th>
                        <th class="px-4 py-3">Price</th>
                        <th class="px-4 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-xs text-slate-700 dark:text-slate-300">
                    @forelse ($items as $item)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition" wire:key="qr-item-{{ $item->id }}">
                            <td class="px-4 py-4 font-bold text-slate-900 dark:text-slate-100">{{ $item->name }}</td>
                            <td class="px-4 py-4 text-slate-500 dark:text-slate-400">{{ $item->sku }}</td>
                            <td class="px-4 py-4 font-semibold text-slate-700 dark:text-slate-300">${{ number_format($item->selling_price, 2) }}</td>
                            <td class="px-4 py-4 text-center">
                                <button type="button"
                                    wire:click="selectItem({{ $item->id }})"
                                    class="px-3.5 py-1.5 bg-indigo-600 text-white rounded-lg text-[11px] font-semibold hover:bg-indigo-700 transition shadow-sm">
                                    <i class="fa-solid fa-qrcode mr-1"></i> Select
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%" class="px-4 py-8 text-center text-slate-400 dark:text-slate-500">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $items->links() }}
        </div>
    </div>

    <!-- Right Column: Generator Preview Panel -->
    <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm space-y-6">
        <h3 class="font-bold text-slate-800 dark:text-slate-100 text-[15px] pb-2 border-b border-slate-100 dark:border-slate-800">QR Code Preview</h3>

        @if ($selectedItem)
            <div class="flex flex-col items-center justify-center p-6 bg-slate-50 dark:bg-slate-800/40 rounded-lg border border-slate-100 dark:border-slate-700/50 shadow-inner"
                x-data="{ 
                    qrData: @js($selectedItem['sku']), 
                    qrSize: 200, 
                    qrColor: '#1e3a8a',
                    renderQr() {
                        try {
                            const canvas = this.$refs.qrCanvas;
                            if (!canvas || !this.qrData) return;
                            if (typeof QRious === 'undefined') {
                                setTimeout(() => this.renderQr(), 300);
                                return;
                            }
                            new QRious({
                                element: canvas,
                                value: this.qrData,
                                size: parseInt(this.qrSize),
                                foreground: 'white',
                                background: this.qrColor,
                                level: 'H'
                            });
                        } catch(e) { console.warn('QR render error:', e); }
                    }
                }"
                x-init="$nextTick(() => renderQr())"
                @qr-item-selected.window="qrData = $event.detail.sku; $nextTick(() => renderQr())"
            >
                <!-- Printable Tag Design -->
                <div id="printable-qr-tag" class="bg-white p-5 rounded-lg border border-slate-200 flex flex-col items-center justify-center text-center max-w-[260px] shadow-sm">
                    <span class="text-[11px] font-bold text-slate-800 tracking-wide uppercase">{{ $selectedItem['name'] }}</span>
                    <span class="text-[9px] text-slate-400 font-semibold mb-3">SKU: {{ $selectedItem['sku'] }}</span>
                    
                    <canvas x-ref="qrCanvas" class="my-2"></canvas>

                    <div class="text-[12px] font-extrabold text-indigo-600 mt-2">${{ number_format($selectedItem['selling_price'], 2) }}</div>
                </div>

                <!-- Interactivity settings -->
                <div class="space-y-4 text-xs w-full mt-6">
                    <div>
                        <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">QR Value (SKU/Code):</label>
                        <input type="text" x-model="qrData" @input="renderQr()" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition" />
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">Size (px):</label>
                        <select x-model="qrSize" @change="renderQr()" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                            <option value="150">150 x 150</option>
                            <option value="200" selected>200 x 200</option>
                            <option value="250">250 x 250</option>
                            <option value="300">300 x 300</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold text-slate-700 dark:text-slate-300 mb-1">Theme Color:</label>
                        <select x-model="qrColor" @change="renderQr()" class="w-full px-3 py-2 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                            <option value="#1e3a8a">Navy Blue</option>
                            <option value="#000000">Classic Black</option>
                            <option value="#047857">Emerald Green</option>
                            <option value="#b91c1c">Crimson Red</option>
                            <option value="#6d28d9">Royal Purple</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-2 w-full mt-4">
                    <button type="button" onclick="printQrTag()" class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-lg text-xs font-semibold hover:bg-indigo-700 transition flex items-center justify-center gap-1.5 shadow-sm">
                        <i class="fa-solid fa-print"></i> Print
                    </button>
                    <button type="button" @click="
                        const canvas = $refs.qrCanvas;
                        if (!canvas) return;
                        const link = document.createElement('a');
                        link.download = 'qr-code.png';
                        link.href = canvas.toDataURL('image/png');
                        link.click();
                    " class="flex-1 px-4 py-2 bg-emerald-600 text-white rounded-lg text-xs font-semibold hover:bg-emerald-700 transition flex items-center justify-center gap-1.5 shadow-sm">
                        <i class="fa-solid fa-download"></i> Download
                    </button>
                    <button type="button" wire:click="clearSelection" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 rounded-lg text-xs font-semibold hover:bg-slate-200 dark:hover:bg-slate-700 transition">
                        Clear
                    </button>
                </div>
            </div>
        @else
            <div class="py-16 text-center text-slate-400 dark:text-slate-500">
                <i class="fa-solid fa-qrcode text-4xl mb-3 opacity-30"></i>
                <p class="text-xs font-medium">Select a product from the list to preview and print its label.</p>
            </div>
        @endif
    </div>

    @push('custom-scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
        <script>
            function printQrTag() {
                const canvas = document.querySelector('#printable-qr-tag canvas');
                if (!canvas) return;
                const imageData = canvas.toDataURL('image/png');

                const tag = document.getElementById('printable-qr-tag');
                if (!tag) return;

                // Replace canvas with base64 img so it renders correctly in the popup
                const tagHtml = tag.outerHTML.replace(
                    /<canvas[^>]*>.*?<\/canvas>/s,
                    `<img src="${imageData}" style="display:block; margin:10px auto;" />`
                );
                
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
                                    background: #fff;
                                }
                                .tag {
                                    padding: 24px;
                                    border: 1px solid #e2e8f0;
                                    border-radius: 10px;
                                    text-align: center;
                                    max-width: 280px;
                                    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
                                }
                                img { display: block; margin: 10px auto; }
                            </style>
                        </head>
                        <body onload="window.print(); window.close();">
                            <div class="tag">${tagHtml}</div>
                        </body>
                    </html>
                `);
                popupWin.document.close();
            }
        </script>
    @endpush
</div>
