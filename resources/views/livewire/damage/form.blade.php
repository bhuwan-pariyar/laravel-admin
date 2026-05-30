<div class="py-2">
    @if (session()->has('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        @csrf
        <div class="bg-white p-6 rounded-1xl border border-slate-200 shadow-sm max-w-2xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="store_id" :value="__('Select Store')" required />
                    <x-select id="store_id" wire:model.live="store_id" class="mt-1 block w-full text-xs" required>
                        <option value="">--- Choose Store ---</option>
                        @foreach ($stores as $str)
                            <option value="{{ $str->id }}">{{ $str->name }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error :messages="$errors->get('store_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="item_id" :value="__('Select Item')" required />
                    <x-select id="item_id" wire:model.live="item_id" class="mt-1 block w-full text-xs" required>
                        <option value="">--- Choose Item ---</option>
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }} (SKU: {{ $item->sku }})</option>
                        @endforeach
                    </x-select>
                    <x-input-error :messages="$errors->get('item_id')" class="mt-2" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <x-input-label for="quantity" :value="__('Damaged Quantity')" required />
                    <x-text-input id="quantity" type="number" wire:model="quantity" class="mt-1 block w-full text-xs" min="1" required />
                    <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                </div>

                <div>
                    <x-input-label :value="__('Current Store Stock')" />
                    <div class="mt-3 text-sm font-bold text-slate-700">
                        {{ $current_stock }}
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <x-input-label for="remarks" :value="__('Description / Remarks')" />
                <x-textarea id="remarks" wire:model="remarks" placeholder="Provide detail on why the item was damaged..." rows="3" class="mt-1 block w-full text-xs" />
                <x-input-error :messages="$errors->get('remarks')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-slate-100">
                <a href="{{ route('damage.list') }}" class="px-4 py-2 text-xs font-medium text-slate-700 bg-slate-100 rounded hover:bg-slate-200 transition">Cancel</a>
                <x-button variant="primary" type="submit" size="sm" class="text-xs">
                    <i class="fa-solid fa-save mr-1.5"></i> Log Damage Report
                </x-button>
            </div>
        </div>
    </form>
</div>
