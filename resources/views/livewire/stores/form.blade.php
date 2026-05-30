<div class="py-2">
    <form wire:submit.prevent="save">
        @csrf
        <div class="bg-white p-6 rounded-1xl border border-slate-200 shadow-sm max-w-2xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="code" :value="__('Store Code')" required />
                    <x-text-input id="code" type="text" placeholder="e.g. ST01" class="mt-1 block w-full"
                        wire:model="code" required />
                    <x-input-error :messages="$errors->get('code')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="name" :value="__('Store Name')" required />
                    <x-text-input id="name" type="text" placeholder="e.g. Main Warehouse" class="mt-1 block w-full"
                        wire:model="name" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6">
                <x-input-label for="location" :value="__('Location / Address')" />
                <x-text-input id="location" type="text" placeholder="Store location details..." class="mt-1 block w-full"
                    wire:model="location" />
                <x-input-error :messages="$errors->get('location')" class="mt-2" />
            </div>

            <div class="mt-6">
                <x-input-label for="status" :value="__('Status')" />
                <x-switch id="status" wire:model="status" :checked="$status" />
                <x-input-error :messages="$errors->get('status')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-slate-100">
                <a href="{{ route('stores.list') }}" class="px-4 py-2 text-sm font-medium text-slate-700 bg-slate-100 rounded hover:bg-slate-200 transition">Cancel</a>
                <x-button variant="primary" type="submit" size="sm">
                    {{ __('Save Store') }}
                </x-button>
            </div>
        </div>
    </form>
</div>
