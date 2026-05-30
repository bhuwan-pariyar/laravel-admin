<div class="py-2">
    <form wire:submit.prevent="save">
        @csrf
        <div class="bg-white p-6 rounded-1xl border border-slate-200 shadow-sm max-w-2xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-input-label for="name" :value="__('Customer Name')" required />
                    <x-text-input id="name" type="text" placeholder="e.g. John Doe" class="mt-1 block w-full"
                        wire:model="name" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email Address')" />
                    <x-text-input id="email" type="email" placeholder="e.g. john@example.com" class="mt-1 block w-full"
                        wire:model="email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <x-input-label for="phone" :value="__('Phone Number')" />
                    <x-text-input id="phone" type="text" placeholder="e.g. +1 555-0199" class="mt-1 block w-full"
                        wire:model="phone" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="status" :value="__('Status')" />
                    <x-switch id="status" wire:model="status" :checked="$status" />
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>
            </div>

            <div class="mt-6">
                <x-input-label for="address" :value="__('Address')" />
                <x-text-input id="address" type="text" placeholder="Customer physical address..." class="mt-1 block w-full"
                    wire:model="address" />
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end gap-3 mt-8 pt-6 border-t border-slate-100">
                <a href="{{ route('customers.list') }}" class="px-4 py-2 text-sm font-medium text-slate-700 bg-slate-100 rounded hover:bg-slate-200 transition">Cancel</a>
                <x-button variant="primary" type="submit" size="sm">
                    {{ __('Save Customer') }}
                </x-button>
            </div>
        </div>
    </form>
</div>
