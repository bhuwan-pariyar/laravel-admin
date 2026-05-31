<div class="py-2">
    @if (session()->has('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Side (2 cols): Items List -->
            <div class="lg:col-span-2 bg-white p-6 rounded-1xl border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-100">
                    <h3 class="font-bold text-slate-800 text-[15px]">Invoice Items</h3>
                    <button type="button" wire:click="addItemRow" class="px-3 py-1.5 bg-blue-50 border border-blue-200 hover:bg-blue-100 text-blue-600 rounded text-xs font-semibold flex items-center gap-1 transition">
                        <i class="fa-solid fa-plus"></i> Add Item
                    </button>
                </div>

                <div class="space-y-4">
                    @foreach ($selected_items as $index => $row)
                        <div wire:key="selected-item-row-{{ $index }}" class="grid grid-cols-12 gap-3 items-center border border-slate-100 p-3 rounded-lg bg-slate-50/50">
                            <!-- Item Select -->
                            <div class="col-span-5">
                                <x-input-label :value="__('Select Product')" class="text-xs" />
                                <x-select wire:model.live="selected_items.{{ $index }}.item_id" class="mt-1 w-full text-xs">
                                    <option value="">Choose item...</option>
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }} (SKU: {{ $item->sku }})</option>
                                    @endforeach
                                </x-select>
                                <x-input-error :messages="$errors->get('selected_items.' . $index . '.item_id')" class="mt-1 text-[10px]" />
                                @if (isset($row['stock']) && $row['item_id'])
                                    <span class="text-[10px] text-slate-500 mt-1 block">Stock: <strong class="text-slate-700">{{ $row['stock'] }}</strong></span>
                                @endif
                            </div>

                            <!-- Price Display -->
                            <div class="col-span-2">
                                <x-input-label :value="__('Price')" class="text-xs" />
                                <x-text-input type="number" step="0.01" value="{{ $row['price'] }}" class="mt-1 w-full text-xs text-right bg-white" readonly />
                            </div>

                            <!-- Quantity Input -->
                            <div class="col-span-2">
                                <x-input-label :value="__('Qty')" class="text-xs" />
                                <x-text-input type="number" wire:model.live="selected_items.{{ $index }}.quantity" class="mt-1 w-full text-xs text-center" min="1" />
                                <x-input-error :messages="$errors->get('selected_items.' . $index . '.quantity')" class="mt-1 text-[10px]" />
                            </div>

                            <!-- Total Display -->
                            <div class="col-span-2">
                                <x-input-label :value="__('Total')" class="text-xs" />
                                <div class="mt-2 text-right text-xs font-bold text-slate-800">
                                    ${{ number_format($row['total'], 2) }}
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="col-span-1 text-center">
                                @if (count($selected_items) > 1)
                                    <button type="button" wire:click="removeItemRow({{ $index }})" class="mt-6 text-red-500 hover:text-red-700">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right Side (1 col): Invoice Metadata & Summary -->
            <div class="bg-white p-6 rounded-1xl border border-slate-200 shadow-sm space-y-5">
                <h3 class="font-bold text-slate-800 text-[15px] pb-2 border-b border-slate-100">Sale Details</h3>

                <div>
                    <x-input-label for="invoice_no" :value="__('Invoice #')" required />
                    <x-text-input id="invoice_no" type="text" wire:model="invoice_no" class="mt-1 block w-full bg-slate-50 text-xs" readonly />
                </div>

                <div>
                    <x-input-label for="store_id" :value="__('Store / Warehouse')" required />
                    <x-select id="store_id" wire:model.live="store_id" class="mt-1 block w-full text-xs" required>
                        <option value="">--- Select Store ---</option>
                        @foreach ($stores as $str)
                            <option value="{{ $str->id }}">{{ $str->name }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error :messages="$errors->get('store_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="customer_id" :value="__('Customer')" required />
                    <x-select id="customer_id" wire:model="customer_id" class="mt-1 block w-full text-xs" required>
                        <option value="">--- Select Customer ---</option>
                        @foreach ($customers as $cust)
                            <option value="{{ $cust->id }}">{{ $cust->name }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error :messages="$errors->get('customer_id')" class="mt-2" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="sale_date" :value="__('Sale Date')" required />
                        <x-text-input id="sale_date" type="date" wire:model="sale_date" class="mt-1 block w-full text-xs" required />
                    </div>

                    <div>
                        <x-input-label for="payment_status" :value="__('Payment Status')" required />
                        <x-select id="payment_status" wire:model="payment_status" class="mt-1 block w-full text-xs" required>
                            <option value="pending">Pending</option>
                            <option value="paid">Paid</option>
                            <option value="partial">Partial</option>
                        </x-select>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 space-y-3">
                    <div class="flex justify-between text-xs text-slate-600 font-medium">
                        <span>Subtotal:</span>
                        <span>${{ number_format($subtotal, 2) }}</span>
                    </div>

                    <div class="grid grid-cols-2 gap-3 items-center">
                        <label class="text-xs text-slate-600 font-medium">Tax (%):</label>
                        <x-text-input type="number" wire:model.live="tax_rate" class="w-full text-xs text-right" placeholder="0" min="0" />
                    </div>

                    <div class="grid grid-cols-2 gap-3 items-center">
                        <label class="text-xs text-slate-600 font-medium">Discount ($):</label>
                        <x-text-input type="number" step="0.01" wire:model.live="discount_amount" class="w-full text-xs text-right" placeholder="0.00" min="0" />
                    </div>

                    <div class="flex justify-between text-sm font-bold text-slate-800 pt-2 border-t border-slate-100">
                        <span>Grand Total:</span>
                        <span class="text-blue-600">${{ number_format($grand_total, 2) }}</span>
                    </div>
                </div>

                <div>
                    <x-input-label for="remarks" :value="__('Remarks / Note')" />
                    <x-textarea id="remarks" wire:model="remarks" placeholder="Sale details, delivery instructions..." rows="2" class="mt-1 block w-full text-xs" />
                </div>

                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ route('sales.list') }}" class="px-4 py-2 text-xs font-medium text-slate-700 bg-slate-100 rounded hover:bg-slate-200 transition">Cancel</a>
                    <x-button variant="primary" type="submit" size="sm" class="text-xs">
                        <i class="fa-solid fa-file-invoice-dollar mr-1.5"></i> {{ __('Complete Sale') }}
                    </x-button>
                </div>
            </div>
        </div>
    </form>
</div>
