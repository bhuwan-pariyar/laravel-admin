<x-app-layout>
    <x-breadcrumb>
        <li><a href="{{ route('dashboard.index') }}"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
        <li><a href="#"><i class="fa-regular fa-rectangle-list"></i> Users</a></li>
        <li><a href="#"><i class="fa-solid fa-user-pen"></i> {{ auth()->user()?->name }}</a></li>
    </x-breadcrumb>

    <div class="mt-0 mr-4 mb-4 ml-4">
        <div
            class="block w-full rounded-sm bg-gray-100 text-center text-surface shadow-sm dark:bg-surface-dark dark:text-white border border-slate-200">
            <div class="px-2 nav nav-tabs border border-b-slate-200">
                <!--Tabs navigation-->
                <ul class="flex list-none flex-row flex-wrap ps-0 mt-2" role="tablist">
                    <li role="presentation">
                        <a href="#user-profile-tab"
                            class="group relative block px-2 py-1 text-xs font-small leading-tight transition-all duration-200 ease-in-out
text-gray-500 hover:text-primary-500 hover:bg-slate-100 focus:outline-none
data-[active]:bg-white
data-[active]:border data-[active]:border-t data-[active]:border-l data-[active]:border-r
data-[active]:border-slate-200
data-[active]:border-b-0
data-[active]:-mb-px
data-[active]:rounded-tl-xs data-[active]:rounded-tr-xs
data-[active]:shadow-sm data-[active]:z-10
data-[active]:after:absolute data-[active]:after:bottom-[-1px] data-[active]:after:left-0 data-[active]:after:h-[1px] data-[active]:after:w-full data-[active]:after:bg-white
dark:data-[active]:bg-surface-dark dark:data-[active]:border-slate-800 dark:data-[active]:after:bg-surface-dark
flex items-center justify-center tab-link"
                            data-target="user-profile-tab" data-active role="tab" aria-controls="user-profile-tab"
                            aria-selected="true">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-4 h-4 mr-1 sm:h-6 transition-colors group-hover:text-primary-500 data-[active]:text-black dark:data-[active]:text-white"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                            </svg>
                            <span
                                class="transition-colors group-hover:text-primary-500 data-[active]:font-medium data-[active]:text-black dark:data-[active]:text-white">
                                User Profile
                            </span>
                        </a>
                    </li>

                    <li role="presentation">
                        <a href="#tabs-profile"
                            class="group block px-2 py-1 text-xs font-small leading-tight transition-all duration-200 ease-in-out text-gray-500 hover:isolate hover:text-primary-500 hover:border-b hover:border-slate-400 hover:bg-slate-100 focus:outline-none data-[active]:bg-white data-[active]:border-t data-[active]:border-l data-[active]:border-r data-[active]:border-b-0 data-[active]:border-slate-200 data-[active]:border-t-black data-[active]:-mb-px data-[active]:rounded-tl-md data-[active]:rounded-tr-md data-[active]:shadow-sm data-[active]:z-10 dark:text-gray-400 dark:hover:bg-slate-700/60 dark:data-[active]:bg-surface-dark dark:data-[active]:border-t-black flex items-center justify-center tab-link relative"
                            data-target="tabs-profile" role="tab" aria-controls="tabs-profile"
                            aria-selected="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="w-4 h-4 mr-1 sm:h-6 transition-colors group-hover:text-primary-500 data-[active]:text-black dark:data-[active]:text-white">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 8v-2a2 2 0 0 1 2 -2h2" />
                                <path d="M4 16v2a2 2 0 0 0 2 2h2" />
                                <path d="M16 4h2a2 2 0 0 1 2 2v2" />
                                <path d="M16 20h2a2 2 0 0 0 2 -2v-2" />
                                <path d="M9 10l.01 0" />
                                <path d="M15 10l.01 0" />
                                <path d="M9.5 15a3.5 3.5 0 0 0 5 0" />
                            </svg>
                            <span
                                class="transition-colors group-hover:text-primary-500 data-[active]:font-medium data-[active]:text-black dark:data-[active]:text-white">Avatar</span>
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#tabs-messages"
                            class="group block px-2 py-1 text-xs font-small leading-tight transition-all duration-200 ease-in-out text-gray-500 hover:isolate hover:text-primary-500 hover:border-b hover:border-slate-400 hover:bg-slate-100 focus:outline-none data-[active]:bg-white data-[active]:border-t data-[active]:border-l data-[active]:border-r data-[active]:border-b-0 data-[active]:border-slate-200 data-[active]:border-t-black data-[active]:-mb-px data-[active]:rounded-tl-md data-[active]:rounded-tr-md data-[active]:shadow-sm data-[active]:z-10 dark:text-gray-400 dark:hover:bg-slate-700/60 dark:data-[active]:bg-surface-dark dark:data-[active]:border-t-black flex items-center justify-center tab-link relative"
                            data-target="tabs-messages" role="tab" aria-controls="tabs-messages"
                            aria-selected="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" viewBox="0 0 24 24"
                                class="w-4 h-4 mr-1 sm:h-6 transition-colors group-hover:text-primary-500 data-[active]:text-black dark:data-[active]:text-white">
                                <path fill="currentColor"
                                    d="M17.615 17.615q.625 0 1.063-.437t.437-1.063t-.437-1.062t-1.063-.438t-1.062.438t-.438 1.062t.438 1.063t1.062.437m0 3q.75 0 1.4-.35t1.075-.975q-.575-.35-1.2-.512t-1.275-.163t-1.275.163t-1.2.512q.425.625 1.075.975t1.4.35M9 9h6V7q0-1.25-.875-2.125T12 4t-2.125.875T9 7zM6.615 21q-.666 0-1.14-.475Q5 20.051 5 19.385v-8.77q0-.666.475-1.14Q5.949 9 6.615 9H8V7q0-1.671 1.164-2.836T12 3t2.836 1.164T16 7v2h1.385q.666 0 1.14.475q.475.474.475 1.14v.285q0 .341-.27.562t-.624.184q-.117-.006-.248-.009q-.13-.002-.262-.002q-2.483 0-4.232 1.749t-1.749 4.231q0 .628.124 1.245t.38 1.19q.143.329-.028.64t-.518.31zm11 .615q-1.67 0-2.835-1.164t-1.165-2.836t1.165-2.835t2.835-1.165t2.836 1.165t1.164 2.835t-1.164 2.836q-1.164 1.164-2.836 1.164" />
                            </svg>
                            <span
                                class="transition-colors group-hover:text-primary-500 data-[active]:font-medium data-[active]:text-black dark:data-[active]:text-white">Change
                                Password</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="p-4 bg-white dark:bg-surface-dark">
                <!-- User Profile Tab -->
                <div class="tab-content opacity-100 transition-opacity duration-300 ease-in-out block active"
                    id="user-profile-tab" role="tabpanel" aria-labelledby="user-profile-tab-tab">
                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-6">
                                <!-- Name -->
                                <x-input-icon name="name" type="text" icon="user" placeholder="Enter name"
                                    value="{{ old('name', $user->name) }}" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="mb-6">
                                <x-input-icon name="username" type="text" icon="user" placeholder="Enter username"
                                    value="{{ old('username', $user->username) }}" required />
                                <x-input-error :messages="$errors->get('username')" class="mt-2" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-6">
                                <!-- Email Address -->
                                <x-input-icon name="email" type="email" icon="email" placeholder="Enter email"
                                    value="{{ old('email', $user->email) }}" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <div class="mb-6">
                                <!-- Address -->
                                <x-input-icon name="address" type="text" icon="address" placeholder="Enter address"
                                    value="{{ old('address', $user->address ?? '') }}" required />
                                <x-input-error :messages="$errors->get('address')" class="mt-2" />
                            </div>
                        </div>
                        <hr>
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-3">
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>

                <!-- Avatar Tab -->
                <div class="tab-content opacity-0 hidden transition-opacity duration-300 ease-in-out"
                    id="tabs-profile" role="tabpanel" aria-labelledby="tabs-profile-tab">
                    <img src="https://tecdn.b-cdn.net/img/new/avatars/1.webp" class="w-32 rounded-full shadow-lg"
                        alt="Avatar" />
                </div>

                <!-- Change Password Tab -->
                <div class="tab-content opacity-0 hidden transition-opacity duration-300 ease-in-out"
                    id="tabs-messages" role="tabpanel" aria-labelledby="tabs-messages-tab">
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')
                        <div class="grid grid-cols-1 gap-4">
                            <div class="mb-6">
                                <!-- Current Password -->
                                <x-input-icon name="current_password" type="password" icon="lock"
                                    placeholder="Enter current password" value="{{ old('current_password') }}"
                                    required />
                                <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-6">
                                <!-- New Password -->
                                <x-input-icon name="new_password" type="password" icon="lock"
                                    placeholder="Enter new password" value="{{ old('new_password') }}" required />
                                <x-input-error :messages="$errors->get('new_password')" class="mt-2" />
                            </div>
                            <div class="mb-6">
                                <!-- Confirm New Password -->
                                <x-input-icon name="confirm_password" type="password" icon="lock"
                                    placeholder="Enter confirm password" value="{{ old('confirm_password') }}"
                                    required />
                                <x-input-error :messages="$errors->get('confirm_password')" class="mt-2" />
                            </div>
                        </div>
                        <hr>
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ms-3">
                                {{ __('Update') }}
                            </x-primary-button>
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

                    tabs.forEach(t => {
                        t.removeAttribute('data-active');
                        t.setAttribute('aria-selected', 'false');
                    });

                    panels.forEach(p => {
                        p.classList.add('hidden');
                        p.classList.remove('block');
                    });

                    // IMPORTANT: attribute exists WITHOUT value
                    tab.setAttribute('data-active', '');
                    tab.setAttribute('aria-selected', 'true');

                    document.getElementById(target)?.classList.remove('hidden');
                    document.getElementById(target)?.classList.add('block');
                }

                tabs.forEach(tab => {
                    tab.addEventListener('click', e => {
                        e.preventDefault();
                        activate(tab);
                    });
                });

                // Init first tab
                const active = document.querySelector('.tab-link[data-active]');
                if (active) activate(active);
            });
        </script>
    @endpush
</x-app-layout>
