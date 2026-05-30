<div class="py-2">
    @if (session()->has('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Side: Items list -->
            <div class="lg:col-span-2 bg-white p-6 rounded-1xl border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between mb-4 pb-2 border-b border-slate-100">
                    <h3 class="font-bold text-slate-800 text-[15px]">Items to Transfer</h3>
                    <button type="button" wire:click="addItemRow" class="px-3 py-1.5 bg-blue-50 border border-blue-200 hover:bg-blue-100 text-blue-600 rounded text-xs font-semibold flex items-center gap-1 transition">
                        <i class="fa-solid fa-plus"></i> Add Row
                    </button>
                </div>

                <div class="space-y-4">
                    @foreach ($selected_items as $index => $row)
                        <div class="grid grid-cols-12 gap-3 items-center border border-slate-100 p-3 rounded-lg bg-slate-50/50">
                            <!-- Item select -->
                            <div class="col-span-7">
                                <x-input-label :value="__('Select Product')" class="text-xs" />
                                <x-select wire:model.live="selected_items.{{ $index }}.item_id" class="mt-1 w-full text-xs">
                                    <option value="">Choose item...</option>
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }} (SKU: {{ $item->sku }})</option>
                                    @endforeach
                                </x-select>
                                <x-input-error :messages="$errors->get('selected_items.' . $index . '.item_id')" class="mt-1 text-[10px]" />
                                @if (isset($row['stock']) && $row['item_id'])
                                    <span class="text-[10px] text-slate-500 mt-1 block font-medium">Available Stock at Source: <strong class="text-slate-700">{{ $row['stock'] }}</strong></span>
                                @endif
                            </div>

                            <!-- Quantity Input -->
                            <div class="col-span-4">
                                <x-input-label :value="__('Qty')" class="text-xs" />
                                <x-text-input type="number" wire:model.live="selected_items.{{ $index }}.quantity" class="mt-1 w-full text-xs text-center" min="1" />
                                <x-input-error :messages="$errors->get('selected_items.' . $index . '.quantity')" class="mt-1 text-[10px]" />
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

            <!-- Right Side: Transfer details -->
            <div class="bg-white p-6 rounded-1xl border border-slate-200 shadow-sm space-y-5">
                <h3 class="font-bold text-slate-800 text-[15px] pb-2 border-b border-slate-100">Transfer Details</h3>

                <div>
                    <x-input-label for="transfer_no" :value="__('Transfer #')" required />
                    <x-text-input id="transfer_no" type="text" wire:model="transfer_no" class="mt-1 block w-full bg-slate-50 text-xs" readonly />
                </div>

                <div>
                    <x-input-label for="from_store_id" :value="__('From (Source) Store')" required />
                    <x-select id="from_store_id" wire:model.live="from_store_id" class="mt-1 block w-full text-xs" required>
                        <option value="">--- Select Source Store ---</option>
                        @foreach ($stores as $str)
                            <option value="{{ $str->id }}">{{ $str->name }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error :messages="$errors->get('from_store_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="to_store_id" :value="__('To (Destination) Store')" required />
                    <x-select id="to_store_id" wire:model.live="to_store_id" class="mt-1 block w-full text-xs" required>
                        <option value="">--- Select Destination Store ---</option>
                        @foreach ($stores as $str)
                            @if ($str->id != $from_store_id)
                                <option value="{{ $str->id }}">{{ $str->name }}</option>
                            @endif
                        @endforeach
                    </x-select>
                    <x-input-error :messages="$errors->get('to_store_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="transfer_date" :value="__('Transfer Date')" required />
                    <x-text-input id="transfer_date" type="date" wire:model="transfer_date" class="mt-1 block w-full text-xs" required />
                    <x-input-error :messages="$errors->get('transfer_date')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="remarks" :value="__('Remarks / Note')" />
                    <x-textarea id="remarks" wire:model="remarks" placeholder="Reason for transfer, driver details..." rows="3" class="mt-1 block w-full text-xs" />
                </div>

                <div class="flex items-center justify-end gap-3 pt-4">
                    <a href="{{ route('transfers.list') }}" class="px-4 py-2 text-xs font-medium text-slate-700 bg-slate-100 rounded hover:bg-slate-200 transition">Cancel</a>
                    <x-button variant="primary" type="submit" size="sm" class="text-xs">
                        <i class="fa-solid fa-exchange-alt mr-1.5"></i> {{ __('Complete Transfer') }}
                    </x-button>
                </div>
            </div>
        </div>
    </form>
</div>
