<div class="py-4">
    @if (session()->has('error'))
        <div class="mb-5 bg-rose-50 border-l-4 border-rose-500 text-rose-700 p-4 rounded shadow-sm text-sm">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <form wire:submit.prevent="save">
        @csrf
        <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-lg transition-all">
            <div class="border-b border-slate-100 pb-5 mb-6">
                <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                    <i class="fa-solid fa-house-damage text-rose-500"></i>
                    {{ $damageId ? 'Edit Damage Report' : 'Log Damage Report' }}
                </h2>
                <p class="text-xs text-slate-500 mt-1">Deduct stock items from a specific store and log the details for system auditing.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="store_id" :value="__('Select Store')" required />
                    <x-select id="store_id" wire:model.live="store_id" class="mt-2.5 block w-full text-xs rounded-lg border-slate-200 focus:border-blue-500 focus:ring-blue-500/20" required>
                        <option value="">--- Choose Store ---</option>
                        @foreach ($stores as $str)
                            <option value="{{ $str->id }}">{{ $str->name }}</option>
                        @endforeach
                    </x-select>
                    <x-input-error :messages="$errors->get('store_id')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="item_id" :value="__('Select Item')" required />
                    <x-select id="item_id" wire:model.live="item_id" class="mt-2.5 block w-full text-xs rounded-lg border-slate-200 focus:border-blue-500 focus:ring-blue-500/20" required>
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
                    <x-text-input id="quantity" type="number" wire:model="quantity" class="mt-2.5 block w-full text-xs rounded-lg border-slate-200 focus:border-blue-500 focus:ring-blue-500/20" min="1" required />
                    <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                </div>

                <div>
                    <x-input-label :value="__('Available Store Stock')" />
                    <div class="mt-3">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold {{ $current_stock > 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                            <span class="w-2.5 h-2.5 rounded-full {{ $current_stock > 0 ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }}"></span>
                            {{ $current_stock }} available
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <x-input-label for="remarks" :value="__('Description / Remarks')" />
                <x-textarea id="remarks" wire:model="remarks" placeholder="Provide detail on why the item was damaged..." rows="3" class="mt-2.5 block w-full text-xs rounded-lg border-slate-200 focus:border-blue-500 focus:ring-blue-500/20" />
                <x-input-error :messages="$errors->get('remarks')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-slate-100">
                <a href="{{ route('damage.list') }}" class="px-4 py-2 text-xs font-semibold text-slate-600 bg-slate-50 border border-slate-200 rounded-lg hover:bg-slate-100 hover:text-slate-800 transition-all">Cancel</a>
                <x-button variant="primary" type="submit" size="sm" class="text-xs bg-rose-600 hover:bg-rose-700 text-white font-semibold py-2 px-4 rounded-lg shadow-sm hover:shadow transition-all">
                    <i class="fa-solid fa-save mr-1.5"></i> {{ $damageId ? 'Update Report' : 'Log Damage Report' }}
                </x-button>
            </div>
        </div>
    </form>
</div>
