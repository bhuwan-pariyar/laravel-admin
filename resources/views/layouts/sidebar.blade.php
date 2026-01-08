<div id="sidebar"
    class="fixed left-0 top-12 w-64 h-[calc(100vh-3rem)] bg-slate-900 dark:bg-slate-900 p-4 z-40 sidebar-menu transition-all">
    <ul class="mt-2 list-none">
        <li class="group no-children {{ active_menu(['dashboard']) }}">
            <a href="{{ route('dashboard.index') }}" data-tooltip="Dashboard"
                class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100 transition-colors duration-200">
                <i class="fa-solid fa-gauge mr-3 text-lg"></i>
                <span class="text-xs">Dashboard</span>
            </a>
        </li>
        <li class="group has-children">
            <a href="#"
                class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100 sidebar-dropdown-toggle transition-colors duration-200">
                <i class="ri-instance-line mr-3 text-lg"></i>
                <span class="text-xs">Orders</span>
                <i
                    class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90 transition-transform duration-200"></i>
            </a>
            <ul class="hidden group-[.selected]:block list-none" data-parent-title="Orders">
                <li>
                    <a href="#"
                        class="text-gray-300 text-xs flex items-center hover:text-gray-100 transition-colors duration-200">Active
                        order</a>
                </li>
                <li>
                    <a href="#"
                        class="text-gray-300 text-xs flex items-center hover:text-gray-100 transition-colors duration-200">Completed
                        order</a>
                </li>
                <li>
                    <a href="#"
                        class="text-gray-300 text-xs flex items-center hover:text-gray-100 transition-colors duration-200">Canceled
                        order</a>
                </li>
            </ul>
        </li>
        <li class="group has-children">
            <a href="#"
                class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100 sidebar-dropdown-toggle transition-colors duration-200">
                <i class="ri-flashlight-line mr-3 text-lg"></i>
                <span class="text-xs">Services</span>
                <i
                    class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90 transition-transform duration-200"></i>
            </a>
            <ul class="hidden group-[.selected]:block list-none" data-parent-title="Services">
                <li>
                    <a href="#"
                        class="text-gray-300 text-xs flex items-center hover:text-gray-100 transition-colors duration-200">Manage
                        services</a>
                </li>
            </ul>
        </li>
        <li class="group no-children {{ active_menu(['settings']) }}">
            <a href="{{ route('settings.index') }}" data-tooltip="Settings"
                class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100 transition-colors duration-200">
                <i class="fa-solid fa-gear mr-3 text-lg"></i>
                <span class="text-xs">Settings</span>
            </a>
        </li>
    </ul>
</div>
<div class="fixed top-0 left-0 w-full h-full bg-black/50 z-30 md:hidden sidebar-overlay hidden"></div>
