<div class="py-2">
    <form wire:submit.prevent="save">
        @csrf
        <div class="grid grid-cols-2 gap-6">
            <!-- Left Side -->
            <div>
                <div class="mb-6">
                    <x-input-label for="item_id" :value="__('Select Item')" required />
                    <x-select id="item_id" wire:model="item_id" class="mt-1 block" required>
                        <option value="">--- Select Item ---</option>
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->name }} (SKU: {{ $item->sku }}) - Current Stock: {{ $item->stock_quantity }}
                            </option>
                        @endforeach
                    </x-select>
                    <x-input-error :messages="$errors->get('item_id')" class="mt-2" />
                </div>

                <div class="mb-6">
                    <x-input-label for="type" :value="__('Transaction Type')" required />
                    <x-select id="type" wire:model="type" class="mt-1 block" required>
                        <option value="in">Stock In (Inward / Add stock)</option>
                        <option value="out">Stock Out (Outward / Remove stock)</option>
                        <option value="purchase">Purchase (Inward / Buy stock)</option>
                        <option value="sale">Sale (Outward / Sell stock)</option>
                        <option value="adjustment">Stock Adjustment (Add positive/negative adjustment)</option>
                    </x-select>
                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                </div>

                <div class="mb-6">
                    <x-input-label for="quantity" :value="__('Quantity')" required />
                    <x-text-input id="quantity" type="number" min="1" class="mt-1 block w-full"
                        wire:model="quantity" required />
                    <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                </div>
            </div>

            <!-- Right Side -->
            <div>
                <div class="mb-6">
                    <x-input-label for="remarks" :value="__('Remarks / Reason')" />
                    <x-textarea id="remarks" wire:model="remarks" placeholder="Provide details, e.g., Purchase Order #123, Damaged item, etc."
                        rows="4" class="mt-1 block w-full"></x-textarea>
                    <x-input-error :messages="$errors->get('remarks')" class="mt-2" />
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
