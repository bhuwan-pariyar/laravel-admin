<div class="py-2">
    @if (session()->has('message'))
        <div class="mb-4 p-4 rounded text-white bg-green-600">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        @csrf
        <div class="grid grid-cols-2 gap-6">
            <!-- Left Column -->
            <div>
                <div class="mb-6">
                    <x-input-label for="company_name" :value="__('Company Name')" required />
                    <x-text-input id="company_name" type="text" placeholder="e.g. Acme Corp" class="mt-1 block w-full"
                        wire:model="company_name" required />
                    <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                </div>

                <div class="mb-6">
                    <x-input-label for="company_email" :value="__('Company Email')" required />
                    <x-text-input id="company_email" type="email" placeholder="e.g. info@acme.com" class="mt-1 block w-full"
                        wire:model="company_email" required />
                    <x-input-error :messages="$errors->get('company_email')" class="mt-2" />
                </div>

                <div class="mb-6">
                    <x-input-label for="company_phone" :value="__('Company Phone')" />
                    <x-text-input id="company_phone" type="text" placeholder="e.g. +1 555-1234" class="mt-1 block w-full"
                        wire:model="company_phone" />
                    <x-input-error :messages="$errors->get('company_phone')" class="mt-2" />
                </div>

                <div class="mb-6">
                    <x-input-label for="company_website" :value="__('Company Website')" />
                    <x-text-input id="company_website" type="text" placeholder="https://example.com" class="mt-1 block w-full"
                        wire:model="company_website" />
                    <x-input-error :messages="$errors->get('company_website')" class="mt-2" />
                </div>
            </div>

            <!-- Right Column -->
            <div>
                <div class="mb-6">
                    <x-input-label for="currency" :value="__('Currency')" required />
                    <x-select id="currency" wire:model="currency" class="mt-1 block w-full" required>
                        <option value="USD">USD ($)</option>
                        <option value="EUR">EUR (€)</option>
                        <option value="GBP">GBP (£)</option>
                        <option value="INR">INR (₹)</option>
                        <option value="AUD">AUD ($)</option>
                    </x-select>
                    <x-input-error :messages="$errors->get('currency')" class="mt-2" />
                </div>

                <div class="mb-6">
                    <x-input-label for="timezone" :value="__('Timezone')" required />
                    <x-select id="timezone" wire:model="timezone" class="mt-1 block w-full" required>
                        <option value="UTC">UTC (GMT+0)</option>
                        <option value="America/New_York">Eastern Time (EST/EDT)</option>
                        <option value="Europe/London">London (GMT/BST)</option>
                        <option value="Asia/Kathmandu">Kathmandu (GMT+5:45)</option>
                        <option value="Asia/Kolkata">Kolkata (GMT+5:30)</option>
                    </x-select>
                    <x-input-error :messages="$errors->get('timezone')" class="mt-2" />
                </div>

                <div class="mb-6">
                    <x-input-label for="company_address" :value="__('Company Address')" />
                    <x-textarea id="company_address" wire:model="company_address" placeholder="Address..."
                        rows="4" class="mt-1 block w-full"></x-textarea>
                    <x-input-error :messages="$errors->get('company_address')" class="mt-2" />
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
                {{ __('Save Changes') }}
            </x-button>
        </div>
    </form>
</div>
