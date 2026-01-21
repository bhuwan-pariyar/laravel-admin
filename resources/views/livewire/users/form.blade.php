<div class="py-2">
    <form wire:submit.prevent="save">
        @csrf
        <div class="grid grid-cols-2 gap-6">
            <!-- Left Side: Input Fields -->
            <div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-6">
                        <x-input-label for="name" :value="__('Name')" required />
                        <x-text-input id="name" type="text" placeholder="Name" class="mt-1 block w-full"
                            wire:model="name" required autocomplete="name"
                            value="{{ old('name', $user->name ?? '') }}" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <div class="mb-6">
                        <x-input-label for="username" :value="__('Username')" required />
                        <x-text-input id="username" type="text" placeholder="Username" class="mt-1 block w-full"
                            wire:model="username" required autocomplete="username"
                            value="{{ old('username', $user->username ?? '') }}" />
                        <x-input-error :messages="$errors->get('username')" class="mt-2" />
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-6">
                        <x-input-label for="email" :value="__('Email')" required />
                        <x-text-input id="email" type="email" placeholder="Email" class="mt-1 block w-full"
                            wire:model="email" required autocomplete="email"
                            value="{{ old('email', $user->email ?? '') }}" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    <div class="mb-6">
                        <x-input-label for="address" :value="__('Address')" required />
                        <x-text-input id="address" type="text" placeholder="Address" class="mt-1 block w-full"
                            wire:model="address" required autocomplete="address"
                            value="{{ old('address', $user->address ?? '') }}" />
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />
                    </div>
                </div>
                @if (!$userId)
                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-6">
                            <x-input-label for="password" :value="__('Password')" required />
                            <x-text-input id="password" type="password" placeholder="Password"
                                class="mt-1 block w-full" wire:model="password" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div class="mb-6">
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" required />
                            <x-text-input id="password_confirmation" type="password" placeholder="Confirm Password"
                                class="mt-1 block w-full" wire:model="password_confirmation" required
                                autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>
                @endif
                <div class="mb-6">
                    <x-input-label for="status" :value="__('Status')" />
                    <x-switch id="status" wire:model="status" :checked="$status" />
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>
            </div>

            <!-- Right Side: File Upload -->
            <div>
                <x-livewire-file-upload wire:model="pic" column="pic" label="Pic"
                    accept="image/jpeg,image/jpg,image/png,image/gif,image/webp" hint="Drop your pic here"
                    :existing="$user?->pic" />
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
