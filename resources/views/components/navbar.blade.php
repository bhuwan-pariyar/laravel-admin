<nav class="fixed top-0 left-0 right-0 bg-dark shadow-sm z-50" x-data="{
    projectDropdown: false,
    messageDropdown: false,
    notificationDropdown: false,
    profileDropdown: false,
    mobileMenu: false
}">
    <div class="flex items-stretch h-16">
        {{-- Logo (mobile only) --}}
        <div class="lg:hidden flex items-center justify-center px-4 border-r border-gray-200">
            <a href="{{-- route('dashboard') --}}" class="flex items-center">
                <img src="{{ asset('assets/images/logo-mini.svg') }}" alt="logo" class="h-8">
            </a>
        </div>

        {{-- Main navbar content --}}
        <div class="flex-1 flex items-center justify-between px-4">
            {{-- Left side - Menu toggle and search --}}
            <div class="flex items-center flex-1 gap-4">
                <button @click="mobileMenu = !mobileMenu" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                {{-- Search bar - hidden on mobile --}}
                <form class="hidden lg:flex flex-1 max-w-md">
                    <div class="relative w-full">
                        <input type="text" placeholder="Search products"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <svg class="absolute right-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </form>
            </div>

            {{-- Right side - Actions --}}
            <div class="flex items-center gap-2">
                {{-- Create New Project Button --}}
                <div class="hidden lg:block relative">
                    <button @click="projectDropdown = !projectDropdown"
                        class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg font-medium transition-colors">
                        + Create New Project
                    </button>

                    <div x-show="projectDropdown" @click.away="projectDropdown = false" x-transition
                        class="absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-xl border border-gray-200 py-2 z-50">
                        <h6 class="px-4 py-2 text-sm font-semibold text-gray-700">Projects</h6>
                        <div class="border-t border-gray-200"></div>

                        <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                            <div class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <p class="text-sm text-gray-700">Software Development</p>
                        </a>

                        <div class="border-t border-gray-200"></div>

                        <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                            <div class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-cyan-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                            </div>
                            <p class="text-sm text-gray-700">UI Development</p>
                        </a>

                        <div class="border-t border-gray-200"></div>

                        <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                            <div class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                </svg>
                            </div>
                            <p class="text-sm text-gray-700">Software Testing</p>
                        </a>

                        <div class="border-t border-gray-200"></div>
                        <p class="px-4 py-2 text-center text-sm text-gray-600">See all projects</p>
                    </div>
                </div>

                {{-- Grid icon --}}
                <a href="#" class="hidden lg:flex p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                </a>

                {{-- Messages dropdown --}}
                <div class="relative border-l border-gray-200 pl-2">
                    <button @click="messageDropdown = !messageDropdown"
                        class="relative p-2 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-green-500 rounded-full"></span>
                    </button>

                    <div x-show="messageDropdown" @click.away="messageDropdown = false" x-transition
                        class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 py-2 z-50">
                        <h6 class="px-4 py-2 text-sm font-semibold text-gray-700">Messages</h6>
                        <div class="border-t border-gray-200"></div>

                        <a href="#"
                            class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                            <img src="{{ asset('assets/images/faces/face4.jpg') }}" alt="Mark"
                                class="w-10 h-10 rounded-full object-cover">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-700 font-medium truncate">Mark send you a message</p>
                                <p class="text-xs text-gray-500">1 Minutes ago</p>
                            </div>
                        </a>

                        <div class="border-t border-gray-200"></div>

                        <a href="#"
                            class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                            <img src="{{ asset('assets/images/faces/face2.jpg') }}" alt="Cregh"
                                class="w-10 h-10 rounded-full object-cover">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-700 font-medium truncate">Cregh send you a message</p>
                                <p class="text-xs text-gray-500">15 Minutes ago</p>
                            </div>
                        </a>

                        <div class="border-t border-gray-200"></div>

                        <a href="#"
                            class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                            <img src="{{ asset('assets/images/faces/face3.jpg') }}" alt="Profile"
                                class="w-10 h-10 rounded-full object-cover">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-700 font-medium truncate">Profile picture updated</p>
                                <p class="text-xs text-gray-500">18 Minutes ago</p>
                            </div>
                        </a>

                        <div class="border-t border-gray-200"></div>
                        <p class="px-4 py-2 text-center text-sm text-gray-600">4 new messages</p>
                    </div>
                </div>

                {{-- Notifications dropdown --}}
                <div class="relative border-l border-gray-200 pl-2">
                    <button @click="notificationDropdown = !notificationDropdown"
                        class="relative p-2 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>

                    <div x-show="notificationDropdown" @click.away="notificationDropdown = false" x-transition
                        class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl border border-gray-200 py-2 z-50">
                        <h6 class="px-4 py-2 text-sm font-semibold text-gray-700">Notifications</h6>
                        <div class="border-t border-gray-200"></div>

                        <a href="#"
                            class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                            <div
                                class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-700 font-medium">Event today</p>
                                <p class="text-xs text-gray-500 truncate">Just a reminder that you have an event today
                                </p>
                            </div>
                        </a>

                        <div class="border-t border-gray-200"></div>

                        <a href="#"
                            class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                            <div
                                class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-700 font-medium">Settings</p>
                                <p class="text-xs text-gray-500">Update dashboard</p>
                            </div>
                        </a>

                        <div class="border-t border-gray-200"></div>

                        <a href="#"
                            class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                            <div
                                class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-700 font-medium">Launch Admin</p>
                                <p class="text-xs text-gray-500">New admin wow!</p>
                            </div>
                        </a>

                        <div class="border-t border-gray-200"></div>
                        <p class="px-4 py-2 text-center text-sm text-gray-600">See all notifications</p>
                    </div>
                </div>

                {{-- Profile dropdown --}}
                <div class="relative">
                    <button @click="profileDropdown = !profileDropdown"
                        class="flex items-center gap-2 p-2 hover:bg-gray-100 rounded-lg transition-colors">
                        <img src="{{ asset('assets/images/faces/face15.jpg') }}" alt="Henry Klein"
                            class="w-8 h-8 rounded-full object-cover">
                        <span class="hidden sm:block text-sm font-medium text-gray-700">Henry Klein</span>
                        <svg class="hidden sm:block w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="profileDropdown" @click.away="profileDropdown = false" x-transition
                        class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl border border-gray-200 py-2 z-50">
                        <h6 class="px-4 py-2 text-sm font-semibold text-gray-700">Profile</h6>
                        <div class="border-t border-gray-200"></div>

                        <a href="#"
                            class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                            <div class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <p class="text-sm text-gray-700">Settings</p>
                        </a>

                        <div class="border-t border-gray-200"></div>

                        <a href="#"
                            class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors">
                            <div class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </div>
                            <p class="text-sm text-gray-700">Log out</p>
                        </a>

                        <div class="border-t border-gray-200"></div>
                        <p class="px-4 py-2 text-center text-sm text-gray-600">Advanced settings</p>
                    </div>
                </div>

                {{-- Mobile menu toggle --}}
                <button @click="mobileMenu = !mobileMenu"
                    class="lg:hidden p-2 hover:bg-gray-100 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>

{{-- Add Alpine.js if not already included --}}
@push('scripts')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
