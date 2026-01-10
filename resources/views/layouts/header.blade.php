<div
    class="py-2 px-6 bg-slate-900 dark:bg-slate-900 flex items-center shadow-md shadow-black/5 sticky top-0 left-0 z-30">
    <a href="#" class="flex items-center mr-3">
        <img id="logoExpanded" src="{{ asset('assets/images/LaraWire.png') }}" alt=""
            class="w-30 h-8 rounded object-cover">
        <img id="logoCollapsed" src="{{ asset('assets/images/LarawireLogo.png') }}" alt=""
            class="w-8 h-8 rounded object-cover hidden">
    </a>
    <!-- Sidebar Toggle Button -->
    <button id="sidebarToggle" type="button"
        class="relative flex items-center justify-center w-8 h-8 text-lg text-gray-300 hover:text-white hover:bg-slate-800 rounded transition-all duration-200 sidebar-toggle mr-3"
        title="Toggle Sidebar">
        <i id="sidebarIconIndent" class="fa-solid fa-indent transition-opacity duration-200 absolute"></i>
        <i id="sidebarIconOutdent" class="fa-solid fa-outdent transition-opacity duration-200 invisible absolute"></i>
    </button>

    <ul class="ml-auto flex items-center">
        <li class="mr-1 dropdown">
            <button type="button"
                class="dropdown-toggle text-gray-300 w-8 h-8 rounded flex items-center justify-center hover:bg-gray-50 hover:text-gray-600">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            <div
                class="dropdown-menu shadow-md shadow-black/5 z-30 hidden max-w-xs w-full bg-white rounded-md border border-gray-100">
                <form action="" class="p-4 border-b border-b-gray-100">
                    <div class="relative w-full">
                        <x-input-icon name="search" type="text" icon="search" placeholder="Search..." required />
                    </div>
                </form>
                <div class="mt-3 mb-2">
                    <div class="text-[13px] font-medium text-gray-300 ml-4 mb-2">Recently</div>
                    <ul class="max-h-64 overflow-y-auto">
                        <li>
                            <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                <img src="https://placehold.co/32x32" alt=""
                                    class="w-8 h-8 rounded block object-cover align-middle">
                                <div class="ml-2">
                                    <div
                                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
                                        Mechanical Keyboard
                                    </div>
                                    <div class="text-[11px] text-gray-300">$120</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                <img src="https://placehold.co/32x32" alt=""
                                    class="w-8 h-8 rounded block object-cover align-middle">
                                <div class="ml-2">
                                    <div
                                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
                                        Wireless Mouse
                                    </div>
                                    <div class="text-[11px] text-gray-300">$235</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                <img src="https://placehold.co/32x32" alt=""
                                    class="w-8 h-8 rounded block object-cover align-middle">
                                <div class="ml-2">
                                    <div
                                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
                                        USB-C Charger
                                    </div>
                                    <div class="text-[11px] text-gray-300">$80</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                <img src="https://placehold.co/32x32" alt=""
                                    class="w-8 h-8 rounded block object-cover align-middle">
                                <div class="ml-2">
                                    <div
                                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
                                        Bluetooth Headphones
                                    </div>
                                    <div class="text-[11px] text-gray-300">$150</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                <img src="https://placehold.co/32x32" alt=""
                                    class="w-8 h-8 rounded block object-cover align-middle">
                                <div class="ml-2">
                                    <div
                                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
                                        External Hard Drive
                                    </div>
                                    <div class="text-[11px] text-gray-300">$300</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                <img src="https://placehold.co/32x32" alt=""
                                    class="w-8 h-8 rounded block object-cover align-middle">
                                <div class="ml-2">
                                    <div
                                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
                                        Noise Cancelling Earbuds
                                    </div>
                                    <div class="text-[11px] text-gray-300">$175</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                <img src="https://placehold.co/32x32" alt=""
                                    class="w-8 h-8 rounded block object-cover align-middle">
                                <div class="ml-2">
                                    <div
                                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
                                        Wireless Mouse</div>
                                    <div class="text-[11px] text-gray-300">$345</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                <img src="https://placehold.co/32x32" alt=""
                                    class="w-8 h-8 rounded block object-cover align-middle">
                                <div class="ml-2">
                                    <div
                                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
                                        USB-C Charger</div>
                                    <div class="text-[11px] text-gray-300">$345</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
        <li class="dropdown">
            <button type="button"
                class="dropdown-toggle text-gray-300 w-8 h-8 rounded flex items-center justify-center hover:bg-gray-50 hover:text-gray-600">
                <i class="fa-regular fa-bell"></i>
            </button>
            <div
                class="dropdown-menu shadow-md shadow-black/5 z-30 hidden max-w-xs w-full bg-white rounded-md border border-gray-100">
                <div class="flex items-center px-4 pt-4 border-b border-b-gray-100 notification-tab">
                    <button type="button" data-tab="notification" data-tab-page="notifications"
                        class="text-gray-300 font-medium text-[13px] hover:text-gray-600 border-b-2 border-b-transparent mr-4 pb-1 active">Notifications</button>
                    <button type="button" data-tab="notification" data-tab-page="messages"
                        class="text-gray-300 font-medium text-[13px] hover:text-gray-600 border-b-2 border-b-transparent mr-4 pb-1">Messages</button>
                </div>
                <div class="my-2">
                    <ul class="max-h-64 overflow-y-auto" data-tab-for="notification" data-page="notifications">

                        <li>
                            <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                <img src="https://placehold.co/32x32" class="w-8 h-8 rounded object-cover">
                                <div class="ml-2">
                                    <div
                                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
                                        Packing Tape Added
                                    </div>
                                    <div class="text-[11px] text-gray-300">
                                        Added by Admin
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                <img src="https://placehold.co/32x32" class="w-8 h-8 rounded object-cover">
                                <div class="ml-2">
                                    <div
                                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
                                        Wireless Mouse Updated
                                    </div>
                                    <div class="text-[11px] text-gray-300">
                                        Stock increased to 120 units
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                <img src="https://placehold.co/32x32" class="w-8 h-8 rounded object-cover">
                                <div class="ml-2">
                                    <div
                                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
                                        USB-C Charger Out of Stock
                                    </div>
                                    <div class="text-[11px] text-gray-300">
                                        Action required
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                <img src="https://placehold.co/32x32" class="w-8 h-8 rounded object-cover">
                                <div class="ml-2">
                                    <div
                                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
                                        Office Chair Price Updated
                                    </div>
                                    <div class="text-[11px] text-gray-300">
                                        Price changed by Manager
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                <img src="https://placehold.co/32x32" class="w-8 h-8 rounded object-cover">
                                <div class="ml-2">
                                    <div
                                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
                                        Laptop Stand Deleted
                                    </div>
                                    <div class="text-[11px] text-gray-300">
                                        Removed from catalog
                                    </div>
                                </div>
                            </a>
                        </li>

                    </ul>
                    <ul class="max-h-64 overflow-y-auto hidden" data-tab-for="notification" data-page="messages">

                        <li>
                            <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                <img src="https://placehold.co/32x32" class="w-8 h-8 rounded object-cover">
                                <div class="ml-2">
                                    <div
                                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
                                        Alex Johnson
                                    </div>
                                    <div class="text-[11px] text-gray-300">
                                        Can you update the stock count?
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                <img src="https://placehold.co/32x32" class="w-8 h-8 rounded object-cover">
                                <div class="ml-2">
                                    <div
                                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
                                        Maria Lopez
                                    </div>
                                    <div class="text-[11px] text-gray-300">
                                        Order #1245 has been shipped.
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                <img src="https://placehold.co/32x32" class="w-8 h-8 rounded object-cover">
                                <div class="ml-2">
                                    <div
                                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
                                        David Smith
                                    </div>
                                    <div class="text-[11px] text-gray-300">
                                        Please review the new item.
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                <img src="https://placehold.co/32x32" class="w-8 h-8 rounded object-cover">
                                <div class="ml-2">
                                    <div
                                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
                                        Sophia Brown
                                    </div>
                                    <div class="text-[11px] text-gray-300">
                                        Payment received successfully.
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="#" class="py-2 px-4 flex items-center hover:bg-gray-50 group">
                                <img src="https://placehold.co/32x32" class="w-8 h-8 rounded object-cover">
                                <div class="ml-2">
                                    <div
                                        class="text-[13px] text-gray-600 font-medium truncate group-hover:text-blue-500">
                                        Ryan Patel
                                    </div>
                                    <div class="text-[11px] text-gray-300">
                                        Need approval for price change.
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>
        <li class="dropdown ml-3">
            <button type="button"
                class="dropdown-toggle text-gray-300 w-8 h-8 rounded flex items-center justify-center hover:bg-gray-50 hover:text-gray-600 group">
                <img src="{{ auth()->user()->pic_url ?? asset('assets/images/user.png') }}" alt=""
                    class="size-6 rounded-full object-cover bg-white ring-2 ring-transparent group-hover:ring-blue-500 transition-all duration-300">
            </button>
            <ul
                class="dropdown-menu shadow-md shadow-black/5 z-30 hidden w-full bg-white rounded-md border border-gray-100  max-w-[140px]">
                <li>
                    <a href="{{ route('profile.index') }}"
                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">
                        <i class="fa-solid fa-user"></i>&nbsp;Profile
                    </a>
                </li>
                <li>
                    <a href="#" onclick="document.getElementById('logout-form').submit();"
                        class="flex items-center text-[13px] py-1.5 px-4 text-gray-600 hover:text-blue-500 hover:bg-gray-50">
                        <i class="fa-solid fa-right-from-bracket"></i>&nbsp;Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="post">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</div>
