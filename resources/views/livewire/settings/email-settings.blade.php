<div class="py-2">
    @if (session()->has('message'))
        <div class="mb-4 p-4 rounded text-white bg-green-600">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        @csrf
        <div class="grid grid-cols-2 gap-6">
            <!-- Left Column: Server connection details -->
            <div>
                <h3 class="text-sm font-semibold text-slate-800 mb-4 border-b pb-2 border-slate-100">SMTP Server Configuration</h3>

                <div class="mb-6">
                    <x-input-label for="mail_mailer" :value="__('Mail Mailer')" required />
                    <x-text-input id="mail_mailer" type="text" placeholder="smtp" class="mt-1 block w-full"
                        wire:model="mail_mailer" required />
                    <x-input-error :messages="$errors->get('mail_mailer')" class="mt-2" />
                </div>

                <div class="mb-6">
                    <x-input-label for="mail_host" :value="__('Mail Host')" required />
                    <x-text-input id="mail_host" type="text" placeholder="smtp.mailtrap.io" class="mt-1 block w-full"
                        wire:model="mail_host" required />
                    <x-input-error :messages="$errors->get('mail_host')" class="mt-2" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-6">
                        <x-input-label for="mail_port" :value="__('Mail Port')" required />
                        <x-text-input id="mail_port" type="number" placeholder="2525" class="mt-1 block w-full"
                            wire:model="mail_port" required />
                        <x-input-error :messages="$errors->get('mail_port')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="mail_encryption" :value="__('Encryption')" />
                        <x-select id="mail_encryption" wire:model="mail_encryption" class="mt-1 block w-full">
                            <option value="">None</option>
                            <option value="tls">TLS</option>
                            <option value="ssl">SSL</option>
                        </x-select>
                        <x-input-error :messages="$errors->get('mail_encryption')" class="mt-2" />
                    </div>
                </div>

                <div class="mb-6">
                    <x-input-label for="mail_username" :value="__('Mail Username')" />
                    <x-text-input id="mail_username" type="text" placeholder="SMTP Username" class="mt-1 block w-full"
                        wire:model="mail_username" />
                    <x-input-error :messages="$errors->get('mail_username')" class="mt-2" />
                </div>

                <div class="mb-6">
                    <x-input-label for="mail_password" :value="__('Mail Password')" />
                    <x-text-input id="mail_password" type="password" placeholder="SMTP Password" class="mt-1 block w-full"
                        wire:model="mail_password" />
                    <x-input-error :messages="$errors->get('mail_password')" class="mt-2" />
                </div>
            </div>

            <!-- Right Column: Sender details -->
            <div>
                <h3 class="text-sm font-semibold text-slate-800 mb-4 border-b pb-2 border-slate-100">Sender Identity Settings</h3>

                <div class="mb-6">
                    <x-input-label for="mail_from_address" :value="__('Sender Email (From Address)')" required />
                    <x-text-input id="mail_from_address" type="email" placeholder="e.g. no-reply@mycompany.com" class="mt-1 block w-full"
                        wire:model="mail_from_address" required />
                    <x-input-error :messages="$errors->get('mail_from_address')" class="mt-2" />
                </div>

                <div class="mb-6">
                    <x-input-label for="mail_from_name" :value="__('Sender Name (From Name)')" required />
                    <x-text-input id="mail_from_name" type="text" placeholder="e.g. Acme Admin Support" class="mt-1 block w-full"
                        wire:model="mail_from_name" required />
                    <x-input-error :messages="$errors->get('mail_from_name')" class="mt-2" />
                </div>

                <!-- Test Connection Hint Box -->
                <div class="bg-slate-50 border border-slate-200 rounded-lg p-5 mt-6">
                    <h4 class="text-xs font-semibold text-slate-700 flex items-center gap-1.5 mb-2">
                        <i class="fa-solid fa-circle-info text-blue-500"></i> Server Details Reminder
                    </h4>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        These settings are loaded dynamically to configure the mail service driver at runtime. Ensure you verify credentials before saving to avoid message queue delivery failures.
                    </p>
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
                {{ __('Save Email Settings') }}
            </x-button>
        </div>
    </form>
</div>
