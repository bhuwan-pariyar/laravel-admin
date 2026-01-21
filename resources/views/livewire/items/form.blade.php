<div class="py-2">
    <form wire:submit.prevent="save">
        @csrf
        <div class="grid grid-cols-2 gap-6">
            <!-- Left Side: Input Fields -->
            <div>
                <div class="mb-6">
                    <x-input-label for="category_id" :value="__('Category')" required />
                    <x-select id="category_id" wire:model="category_id" class="mt-1 block" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ old('category_id', $item->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </x-select>
                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                </div>

                <div class="mb-6">
                    <x-input-label for="name" :value="__('Item Name')" required />
                    <x-text-input id="name" type="text" placeholder="Item Name" class="mt-1 block w-full"
                        wire:model="name" required autocomplete="name" value="{{ old('name', $item->name ?? '') }}" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-6">
                        <x-input-label for="sku" :value="__('SKU')" required />
                        <x-text-input id="sku" type="text" placeholder="SKU" class="mt-1 block w-full"
                            wire:model="sku" required value="{{ old('sku', $item->sku ?? '') }}" />
                        <x-input-error :messages="$errors->get('sku')" class="mt-2" />
                    </div>
                    <div class="mb-6">
                        <x-input-label for="barcode" :value="__('Barcode')" />
                        <x-text-input id="barcode" type="text" placeholder="Barcode (Optional)"
                            class="mt-1 block w-full" wire:model="barcode"
                            value="{{ old('barcode', $item->barcode ?? '') }}" />
                        <x-input-error :messages="$errors->get('barcode')" class="mt-2" />
                    </div>
                </div>

                <div class="mb-6">
                    <x-input-label for="description" :value="__('Description')" />
                    <x-textarea id="description" wire:model="description" placeholder="Item description..."
                        rows="3"
                        class="mt-1 block">{{ old('description', $item->description ?? '') }}</x-textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-6">
                        <x-input-label for="cost_price" :value="__('Cost Price')" required />
                        <x-text-input id="cost_price" type="number" placeholder="0.00" class="mt-1 block w-full"
                            wire:model="cost_price" required step="0.01" min="0"
                            value="{{ old('cost_price', $item->cost_price ?? '') }}" />
                        <x-input-error :messages="$errors->get('cost_price')" class="mt-2" />
                    </div>
                    <div class="mb-6">
                        <x-input-label for="selling_price" :value="__('Selling Price')" required />
                        <x-text-input id="selling_price" type="number" placeholder="0.00" class="mt-1 block w-full"
                            wire:model="selling_price" required step="0.01" min="0"
                            value="{{ old('selling_price', $item->selling_price ?? '') }}" />
                        <x-input-error :messages="$errors->get('selling_price')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-6">
                        <x-input-label for="stock_quantity" :value="__('Stock Quantity')" required />
                        <x-text-input id="stock_quantity" type="number" placeholder="0" class="mt-1 block w-full"
                            wire:model="stock_quantity" required min="0"
                            value="{{ old('stock_quantity', $item->stock_quantity ?? 0) }}" />
                        <x-input-error :messages="$errors->get('stock_quantity')" class="mt-2" />
                    </div>
                    <div class="mb-6">
                        <x-input-label for="reorder_level" :value="__('Reorder Level')" required />
                        <x-text-input id="reorder_level" type="number" placeholder="5" class="mt-1 block w-full"
                            wire:model="reorder_level" required min="0"
                            value="{{ old('reorder_level', $item->reorder_level ?? 5) }}" />
                        <x-input-error :messages="$errors->get('reorder_level')" class="mt-2" />
                    </div>
                </div>

                <div class="mb-6">
                    <x-input-label for="status" :value="__('Status')" />
                    <x-switch id="status" wire:model="status" :checked="$status" />
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>
            </div>

            <!-- Right Side: Image Upload & Summary -->
            <div class="space-y-6">
                <div>
                    <x-livewire-file-upload wire:model="image" column="image" label="Item Image"
                        accept="image/jpeg,image/jpg,image/png,image/gif,image/webp" hint="Drop your image here"
                        :existing="$item?->image" />
                </div>

                <div class="bg-slate-50 rounded-lg p-4">
                    <h3 class="text-sm font-semibold text-slate-900 mb-4">Summary</h3>

                    <div class="space-y-3">
                        <div class="flex justify-between items-center pb-3 border-b border-slate-200">
                            <span class="text-xs text-slate-600">Cost Price:</span>
                            <span
                                class="text-sm font-semibold text-slate-900">${{ $cost_price ? number_format($cost_price, 2) : '0.00' }}</span>
                        </div>

                        <div class="flex justify-between items-center pb-3 border-b border-slate-200">
                            <span class="text-xs text-slate-600">Selling Price:</span>
                            <span
                                class="text-sm font-semibold text-slate-900">${{ $selling_price ? number_format($selling_price, 2) : '0.00' }}</span>
                        </div>

                        <div class="flex justify-between items-center pb-3 border-b border-slate-200">
                            <span class="text-xs text-slate-600">Profit per Unit:</span>
                            <span
                                class="text-sm font-semibold {{ $selling_price && $cost_price && $selling_price - $cost_price > 0 ? 'text-green-600' : 'text-slate-900' }}">
                                ${{ $selling_price && $cost_price ? number_format($selling_price - $cost_price, 2) : '0.00' }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center pb-3 border-b border-slate-200">
                            <span class="text-xs text-slate-600">Profit Margin:</span>
                            <span
                                class="text-sm font-semibold {{ $selling_price && $cost_price && $cost_price > 0 && (($selling_price - $cost_price) / $cost_price) * 100 > 0 ? 'text-green-600' : 'text-slate-900' }}">
                                {{ $selling_price && $cost_price && $cost_price > 0 ? number_format((($selling_price - $cost_price) / $cost_price) * 100, 2) : '0' }}%
                            </span>
                        </div>

                        <div class="flex justify-between items-center pt-2">
                            <span class="text-xs text-slate-600">Stock Level:</span>
                            <span
                                class="text-sm font-semibold {{ $stock_quantity <= $reorder_level ? 'text-red-600' : 'text-green-600' }}">
                                {{ $stock_quantity }} / {{ $reorder_level }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-slate-200">
            <x-button variant="primary" type="submit" size="sm">
                <svg height="14" width="14" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M5.008 2H2.282c-.181 0-.245.002-.275.007c-.005.03-.007.094-.007.275v11.436c0 .181.002.245.007.275c.03.005.094.007.275.007h11.436c.181 0 .245-.002.275-.007c.005-.03.007-.094.007-.275V4.62c0-.13-.001-.18-.004-.204a2.654 2.654 0 0 0-.141-.147L11.73 2.145a2.654 2.654 0 0 0-.147-.141A2.654 2.654 0 0 0 11.38 2h-.388c.005.08.008.172.008.282v2.436c0 .446-.046.607-.134.77a.909.909 0 0 1-.378.378c-.163.088-.324.134-.77.134H6.282c-.446 0-.607-.046-.77-.134a.909.909 0 0 1-.378-.378C5.046 5.325 5 5.164 5 4.718V2.282c0-.11.003-.202.008-.282M2.282 1h9.098c.259 0 .348.01.447.032a.87.87 0 0 1 .273.113c.086.054.156.11.338.293l2.124 2.124c.182.182.239.252.293.338a.87.87 0 0 1 .113.273c.023.1.032.188.032.447v9.098c0 .446-.046.607-.134.77a.909.909 0 0 1-.378.378c-.163.088-.324.134-.77.134H2.282c-.446 0-.607-.046-.77-.134a.909.909 0 0 1-.378-.378c-.088-.163-.134-.324-.134-.77V2.282c0-.446.046-.607.134-.77a.909.909 0 0 1 .378-.378c.163-.088.324-.134.77-.134M6 2.282v2.436c0 .181.002.245.007.275c.03.005.094.007.275.007h3.436c.181 0 .245-.002.275-.007c.005-.03.007-.094.007-.275V2.282c0-.181-.002-.245-.007-.275A2.248 2.248 0 0 0 9.718 2H6.282c-.181 0-.245.002-.275.007c-.005.03-.007.094-.007.275M8 12a2 2 0 1 1 0-4a2 2 0 0 1 0 4m0-1a1 1 0 1 0 0-2a1 1 0 0 0 0 2"
                        fill="currentColor" />
                </svg>&nbsp;
                {{ __('Submit') }}
            </x-button>
        </div>
    </form>
</div>
