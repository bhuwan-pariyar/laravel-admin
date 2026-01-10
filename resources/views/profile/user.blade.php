<x-app-layout>
    <x-breadcrumb>
        <li><a href="{{ route('dashboard.index') }}"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
        <li><a href="#"><i class="fa-regular fa-rectangle-list"></i> Users</a></li>
        <li><a href="#"><i class="fa-solid fa-user-pen"></i> {{ auth()->user()?->name }}</a></li>
    </x-breadcrumb>

    <div class="mt-0 mr-4 mb-4 ml-4">
        <div
            class="block w-full rounded-sm bg-slate-50 text-center text-surface shadow-sm dark:bg-surface-dark dark:text-white border border-slate-200">
            <div class="px-2 nav nav-tabs border-b border-slate-200">
                <ul class="flex list-none flex-row flex-wrap ps-0 mt-3" role="tablist">
                    <li role="presentation">
                        <a href="#user-profile-tab"
                            class="tab-link group relative block px-4 py-1.5 text-sm font-small leading-tight transition-all duration-200 ease-in-out text-slate-500 focus:outline-none flex items-center justify-center place-content-around gap-2"
                            data-target="user-profile-tab" data-active role="tab" aria-controls="user-profile-tab"
                            aria-selected="true">
                            <svg height="16" width="16" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M22 3H2c-1.09.04-1.96.91-2 2v14c.04 1.09.91 1.96 2 2h20c1.09-.04 1.96-.91 2-2V5a2.074 2.074 0 0 0-2-2m0 16H2V5h20v14m-8-2v-1.25c0-1.66-3.34-2.5-5-2.5c-1.66 0-5 .84-5 2.5V17h10M9 7a2.5 2.5 0 0 0-2.5 2.5A2.5 2.5 0 0 0 9 12a2.5 2.5 0 0 0 2.5-2.5A2.5 2.5 0 0 0 9 7m5 0v1h6V7h-6m0 2v1h6V9h-6m0 2v1h4v-1h-4"
                                    fill="currentColor" />
                            </svg>
                            <span class="transition-colors group-hover:text-primary-500">
                                User Profile
                            </span>
                        </a>
                    </li>

                    <li role="presentation">
                        <a href="#tabs-profile"
                            class="tab-link group relative block px-4 py-1.5 text-sm font-small leading-tight transition-all duration-200 ease-in-out text-slate-500 focus:outline-none flex items-center justify-center place-content-around gap-2"
                            data-target="tabs-profile" role="tab" aria-controls="tabs-profile"
                            aria-selected="false">
                            <svg height="16" width="16" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M3 3h18v18H3V3zm16 16V5H5v14h14zM14 7h-4v4h4V7zm1 6H9v2H7v2h2v-2h6v2h2v-2h-2v-2z"
                                    fill="currentColor" />
                            </svg>
                            <span class="transition-colors group-hover:text-primary-500">Avatar</span>
                        </a>
                    </li>

                    <li role="presentation">
                        <a href="#tabs-messages"
                            class="tab-link group relative block px-4 py-1.5 text-sm font-small leading-tight transition-all duration-200 ease-in-out text-slate-500 focus:outline-none flex items-center justify-center place-content-around gap-2"
                            data-target="tabs-messages" role="tab" aria-controls="tabs-messages"
                            aria-selected="false">
                            <svg height="16" width="16" viewBox="0 0 582 1000"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M582 413v356q0 32-32 32H32q-32 0-32-32V413q0-10 3-16.5t7-10t12-5t13-2t15.5 0t14.5.5V253h1q9-87 74-140.5T293 59t151 62.5T515 273h1l2 107q4 0 14.5-.5t15 0t13 2t12 5t6.5 10t3 16.5zM421 251q0-51-37-74t-91-23q-53 0-92 25.5T162 256v124h259V251z"
                                    fill="currentColor" />
                            </svg>
                            <span class="transition-colors group-hover:text-primary-500">Change Password</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="p-4 bg-white dark:bg-surface-dark">
                <!-- User Profile Tab -->
                <div class="tab-content opacity-100 transition-opacity duration-300 ease-in-out block"
                    id="user-profile-tab" role="tabpanel" aria-labelledby="user-profile-tab-tab">
                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-6">
                                <x-input-icon name="name" id="user-name" type="text" icon="user"
                                    placeholder="Enter name" value="{{ old('name', $user->name) }}" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="mb-6">
                                <x-input-icon name="username" id="user-username" type="text" icon="user"
                                    placeholder="Enter username" value="{{ old('username', $user->username) }}"
                                    required />
                                <x-input-error :messages="$errors->get('username')" class="mt-2" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-6">
                                <x-input-icon name="email" id="user-email" type="email" icon="email"
                                    placeholder="Enter email" value="{{ old('email', $user->email) }}" disabled
                                    required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <div class="mb-6">
                                <x-input-icon name="address" id="user-address" type="text" icon="address"
                                    placeholder="Enter address" value="{{ old('address', $user->address ?? '') }}"
                                    required />
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>
                        </div>
                        <hr class="my-4 border-t border-slate-200">
                        <div class="flex items-center justify-end mt-4">
                            <x-button variant="slate" type="submit">
                                <svg height="14" width="14" viewBox="0 0 16 16"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5.008 2H2.282c-.181 0-.245.002-.275.007c-.005.03-.007.094-.007.275v11.436c0 .181.002.245.007.275c.03.005.094.007.275.007h11.436c.181 0 .245-.002.275-.007c.005-.03.007-.094.007-.275V4.62c0-.13-.001-.18-.004-.204a2.654 2.654 0 0 0-.141-.147L11.73 2.145a2.654 2.654 0 0 0-.147-.141A2.654 2.654 0 0 0 11.38 2h-.388c.005.08.008.172.008.282v2.436c0 .446-.046.607-.134.77a.909.909 0 0 1-.378.378c-.163.088-.324.134-.77.134H6.282c-.446 0-.607-.046-.77-.134a.909.909 0 0 1-.378-.378C5.046 5.325 5 5.164 5 4.718V2.282c0-.11.003-.202.008-.282M2.282 1h9.098c.259 0 .348.01.447.032a.87.87 0 0 1 .273.113c.086.054.156.11.338.293l2.124 2.124c.182.182.239.252.293.338a.87.87 0 0 1 .113.273c.023.1.032.188.032.447v9.098c0 .446-.046.607-.134.77a.909.909 0 0 1-.378.378c-.163.088-.324.134-.77.134H2.282c-.446 0-.607-.046-.77-.134a.909.909 0 0 1-.378-.378c-.088-.163-.134-.324-.134-.77V2.282c0-.446.046-.607.134-.77a.909.909 0 0 1 .378-.378c.163-.088.324-.134.77-.134M6 2.282v2.436c0 .181.002.245.007.275c.03.005.094.007.275.007h3.436c.181 0 .245-.002.275-.007c.005-.03.007-.094.007-.275V2.282c0-.181-.002-.245-.007-.275A2.248 2.248 0 0 0 9.718 2H6.282c-.181 0-.245.002-.275.007c-.005.03-.007.094-.007.275M8 12a2 2 0 1 1 0-4a2 2 0 0 1 0 4m0-1a1 1 0 1 0 0-2a1 1 0 0 0 0 2"
                                        fill="currentColor" />
                                </svg>&nbsp;
                                {{ __('Update') }}
                            </x-button>
                        </div>
                    </form>
                </div>

                <!-- Avatar Tab -->
                <div class="tab-content opacity-0 hidden transition-opacity duration-300 ease-in-out"
                    id="tabs-profile" role="tabpanel" aria-labelledby="tabs-profile-tab">
                    <form action="{{ route('profile.uploadImage') }}" id="userAvatar" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <x-file-upload name="pic" label="Profile Image"
                            accept="image/jpeg,image/jpg,image/png,image/gif,image/webp" hint="Drag & drop image here"
                            :existing="$user['pic'] ?? null" />

                        <hr class="my-4 border-t border-slate-200">
                        <div class="flex items-center justify-end mt-4">
                            <x-button variant="slate" type="submit">
                                <svg height="14" width="14" viewBox="0 0 16 16"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5.008 2H2.282c-.181 0-.245.002-.275.007c-.005.03-.007.094-.007.275v11.436c0 .181.002.245.007.275c.03.005.094.007.275.007h11.436c.181 0 .245-.002.275-.007c.005-.03.007-.094.007-.275V4.62c0-.13-.001-.18-.004-.204a2.654 2.654 0 0 0-.141-.147L11.73 2.145a2.654 2.654 0 0 0-.147-.141A2.654 2.654 0 0 0 11.38 2h-.388c.005.08.008.172.008.282v2.436c0 .446-.046.607-.134.77a.909.909 0 0 1-.378.378c-.163.088-.324.134-.77.134H6.282c-.446 0-.607-.046-.77-.134a.909.909 0 0 1-.378-.378C5.046 5.325 5 5.164 5 4.718V2.282c0-.11.003-.202.008-.282M2.282 1h9.098c.259 0 .348.01.447.032a.87.87 0 0 1 .273.113c.086.054.156.11.338.293l2.124 2.124c.182.182.239.252.293.338a.87.87 0 0 1 .113.273c.023.1.032.188.032.447v9.098c0 .446-.046.607-.134.77a.909.909 0 0 1-.378.378c-.163.088-.324.134-.77.134H2.282c-.446 0-.607-.046-.77-.134a.909.909 0 0 1-.378-.378c-.088-.163-.134-.324-.134-.77V2.282c0-.446.046-.607.134-.77a.909.909 0 0 1 .378-.378c.163-.088.324-.134.77-.134M6 2.282v2.436c0 .181.002.245.007.275c.03.005.094.007.275.007h3.436c.181 0 .245-.002.275-.007c.005-.03.007-.094.007-.275V2.282c0-.181-.002-.245-.007-.275A2.248 2.248 0 0 0 9.718 2H6.282c-.181 0-.245.002-.275.007c-.005.03-.007.094-.007.275M8 12a2 2 0 1 1 0-4a2 2 0 0 1 0 4m0-1a1 1 0 1 0 0-2a1 1 0 0 0 0 2"
                                        fill="currentColor" />
                                </svg>&nbsp;
                                {{ __('Update') }}
                            </x-button>
                        </div>
                    </form>
                </div>

                <!-- Change Password Tab -->
                <div class="tab-content opacity-0 hidden transition-opacity duration-300 ease-in-out"
                    id="tabs-messages" role="tabpanel" aria-labelledby="tabs-messages-tab">
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')
                        <div class="grid grid-cols-1 gap-4">
                            <div class="mb-6">
                                <x-input-icon name="current_password" id="current-password" type="password"
                                    icon="lock" placeholder="Enter current password"
                                    value="{{ old('current_password') }}" required />
                                <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-6">
                                <x-input-icon name="new_password" id="new-password" type="password" icon="lock"
                                    placeholder="Enter new password" value="{{ old('new_password') }}" required />
                                <x-input-error :messages="$errors->get('new_password')" class="mt-2" />
                            </div>
                            <div class="mb-6">
                                <x-input-icon name="confirm_password" id="confirm-password" type="password"
                                    icon="lock" placeholder="Enter confirm password"
                                    value="{{ old('confirm_password') }}" required />
                                <x-input-error :messages="$errors->get('confirm_password')" class="mt-2" />
                            </div>
                        </div>
                        <hr class="my-4 border-t border-slate-200">
                        <div class="flex items-center justify-end mt-4">
                            <x-button variant="slate" type="submit">
                                <svg height="14" width="14" viewBox="0 0 16 16"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M5.008 2H2.282c-.181 0-.245.002-.275.007c-.005.03-.007.094-.007.275v11.436c0 .181.002.245.007.275c.03.005.094.007.275.007h11.436c.181 0 .245-.002.275-.007c.005-.03.007-.094.007-.275V4.62c0-.13-.001-.18-.004-.204a2.654 2.654 0 0 0-.141-.147L11.73 2.145a2.654 2.654 0 0 0-.147-.141A2.654 2.654 0 0 0 11.38 2h-.388c.005.08.008.172.008.282v2.436c0 .446-.046.607-.134.77a.909.909 0 0 1-.378.378c-.163.088-.324.134-.77.134H6.282c-.446 0-.607-.046-.77-.134a.909.909 0 0 1-.378-.378C5.046 5.325 5 5.164 5 4.718V2.282c0-.11.003-.202.008-.282M2.282 1h9.098c.259 0 .348.01.447.032a.87.87 0 0 1 .273.113c.086.054.156.11.338.293l2.124 2.124c.182.182.239.252.293.338a.87.87 0 0 1 .113.273c.023.1.032.188.032.447v9.098c0 .446-.046.607-.134.77a.909.909 0 0 1-.378.378c-.163.088-.324.134-.77.134H2.282c-.446 0-.607-.046-.77-.134a.909.909 0 0 1-.378-.378c-.088-.163-.134-.324-.134-.77V2.282c0-.446.046-.607.134-.77a.909.909 0 0 1 .378-.378c.163-.088.324-.134.77-.134M6 2.282v2.436c0 .181.002.245.007.275c.03.005.094.007.275.007h3.436c.181 0 .245-.002.275-.007c.005-.03.007-.094.007-.275V2.282c0-.181-.002-.245-.007-.275A2.248 2.248 0 0 0 9.718 2H6.282c-.181 0-.245.002-.275.007c-.005.03-.007.094-.007.275M8 12a2 2 0 1 1 0-4a2 2 0 0 1 0 4m0-1a1 1 0 1 0 0-2a1 1 0 0 0 0 2"
                                        fill="currentColor" />
                                </svg>&nbsp;
                                {{ __('Update') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('custom-scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const tabs = document.querySelectorAll('.tab-link');
                const panels = document.querySelectorAll('.tab-content');

                function activate(tab) {
                    const target = tab.dataset.target;

                    // Remove active state from all tabs
                    tabs.forEach(t => {
                        t.removeAttribute('data-active');
                        t.setAttribute('aria-selected', 'false');
                    });

                    // Hide all panels
                    panels.forEach(p => {
                        p.classList.add('hidden', 'opacity-0');
                        p.classList.remove('block', 'opacity-100');
                    });

                    // Set active tab
                    tab.setAttribute('data-active', '');
                    tab.setAttribute('aria-selected', 'true');

                    // Show active panel
                    const activePanel = document.getElementById(target);
                    if (activePanel) {
                        activePanel.classList.remove('hidden', 'opacity-0');
                        activePanel.classList.add('block', 'opacity-100');
                    }
                }

                // Add click listeners
                tabs.forEach(tab => {
                    tab.addEventListener('click', e => {
                        e.preventDefault();
                        activate(tab);
                    });
                });

                // Initialize first active tab
                const initialActive = document.querySelector('.tab-link[data-active]');
                if (initialActive) {
                    activate(initialActive);
                }
            });
        </script>
    @endpush
</x-app-layout>
