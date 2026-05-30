<div id="sidebar"
    class="fixed left-0 top-12 w-64 h-[calc(100vh-3rem)] bg-slate-900 dark:bg-slate-900 p-4 z-40 sidebar-menu transition-all">
    <ul class="mt-4 space-y-1.5 list-none px-2">
        <li class="group no-children {{ active_menu(['dashboard']) }}">
            <a href="{{ route('dashboard.index') }}" data-tooltip="Dashboard"
                class="flex items-center py-2.5 px-4 text-slate-300 hover:bg-slate-800/60 hover:text-white group-[.active]:bg-blue-600 group-[.active]:text-white rounded-lg transition-all duration-200">
                <i class="fa-solid fa-gauge mr-3.5 text-[1.1rem] opacity-80 group-[.active]:opacity-100 transition-opacity"></i>
                <span class="text-[13px] font-medium tracking-wide">Dashboard</span>
            </a>
        </li>
        @can('view categories')
        <li class="group no-children {{ active_menu(['categories*']) }}">
            <a href="{{ route('categories.list') }}" data-tooltip="Categories"
                class="flex items-center py-2.5 px-4 text-slate-300 hover:bg-slate-800/60 hover:text-white group-[.active]:bg-blue-600 group-[.active]:text-white rounded-lg transition-all duration-200">
                <i class="fa-solid fa-layer-group mr-3.5 text-[1.1rem] opacity-80 group-[.active]:opacity-100 transition-opacity"></i>
                <span class="text-[13px] font-medium tracking-wide">Categories</span>
            </a>
        </li>
        @endcan
        @can('view items')
        <li class="group no-children {{ active_menu(['items*']) }}">
            <a href="{{ route('items.list') }}" data-tooltip="Items"
                class="flex items-center py-2.5 px-4 text-slate-300 hover:bg-slate-800/60 hover:text-white group-[.active]:bg-blue-600 group-[.active]:text-white rounded-lg transition-all duration-200">
                <i class="fa-solid fa-boxes mr-3.5 text-[1.1rem] opacity-80 group-[.active]:opacity-100 transition-opacity"></i>
                <span class="text-[13px] font-medium tracking-wide">Items</span>
            </a>
        </li>
        @endcan
        @can('view suppliers')
        <li class="group no-children {{ active_menu(['suppliers*']) }}">
            <a href="{{ route('suppliers.list') }}" data-tooltip="Suppliers"
                class="flex items-center py-2.5 px-4 text-slate-300 hover:bg-slate-800/60 hover:text-white group-[.active]:bg-blue-600 group-[.active]:text-white rounded-lg transition-all duration-200">
                <i class="fa-solid fa-truck mr-3.5 text-[1.1rem] opacity-80 group-[.active]:opacity-100 transition-opacity"></i>
                <span class="text-[13px] font-medium tracking-wide">Suppliers</span>
            </a>
        </li>
        @endcan
        @can('view transactions')
        <li class="group no-children {{ active_menu(['transactions*']) }}">
            <a href="{{ route('transactions.list') }}" data-tooltip="Stock Transactions"
                class="flex items-center py-2.5 px-4 text-slate-300 hover:bg-slate-800/60 hover:text-white group-[.active]:bg-blue-600 group-[.active]:text-white rounded-lg transition-all duration-200">
                <i class="fa-solid fa-exchange-alt mr-3.5 text-[1.1rem] opacity-80 group-[.active]:opacity-100 transition-opacity"></i>
                <span class="text-[13px] font-medium tracking-wide">Transactions</span>
            </a>
        </li>
        @endcan
        @can('view users')
        <li class="group no-children {{ active_menu(['users*']) }}">
            <a href="{{ route('users.list') }}" data-tooltip="Users"
                class="flex items-center py-2.5 px-4 text-slate-300 hover:bg-slate-800/60 hover:text-white group-[.active]:bg-blue-600 group-[.active]:text-white rounded-lg transition-all duration-200">
                <i class="fa-solid fa-users mr-3.5 text-[1.1rem] opacity-80 group-[.active]:opacity-100 transition-opacity"></i>
                <span class="text-[13px] font-medium tracking-wide">Users</span>
            </a>
        </li>
        @endcan
        @can('view roles')
        <li class="group no-children {{ active_menu(['roles*']) }}">
            <a href="{{ route('roles.list') }}" data-tooltip="Roles & Permissions"
                class="flex items-center py-2.5 px-4 text-slate-300 hover:bg-slate-800/60 hover:text-white group-[.active]:bg-blue-600 group-[.active]:text-white rounded-lg transition-all duration-200">
                <i class="fa-solid fa-shield-halved mr-3.5 text-[1.1rem] opacity-80 group-[.active]:opacity-100 transition-opacity"></i>
                <span class="text-[13px] font-medium tracking-wide">Roles & Perms</span>
            </a>
        </li>
        @endcan
        <li class="group has-children {{ active_menu(['settings*']) }}">
            <a href="#"
                class="flex items-center py-2.5 px-4 text-slate-300 hover:bg-slate-800/60 hover:text-white group-[.active]:bg-slate-800 group-[.active]:text-white group-[.selected]:bg-slate-800/80 group-[.selected]:text-white sidebar-dropdown-toggle rounded-lg transition-all duration-200">
                <i class="fa-solid fa-gear mr-3.5 text-[1.1rem] opacity-80 transition-opacity"></i>
                <span class="text-[13px] font-medium tracking-wide">Settings</span>
                <i
                    class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90 transition-transform duration-200"></i>
            </a>
            <ul class="hidden group-[.selected]:block list-none mt-1 space-y-1 pl-4" data-parent-title="Settings">
                <li>
                    <a href="{{ route('settings.index') }}"
                        class="text-slate-400 text-[12px] font-medium py-1.5 px-4 flex items-center hover:text-white transition-colors duration-200">Company
                        Profile</a>
                </li>
                <li>
                    <a href="{{ route('settings.departments.list') }}"
                        class="text-slate-400 text-[12px] font-medium py-1.5 px-4 flex items-center hover:text-white transition-colors duration-200">Departments</a>
                </li>
                <li>
                    <a href="{{ route('settings.email') }}"
                        class="text-slate-400 text-[12px] font-medium py-1.5 px-4 flex items-center hover:text-white transition-colors duration-200">Email</a>
                </li>
                <li>
                    <a href="{{ route('settings.backup') }}"
                        class="text-slate-400 text-[12px] font-medium py-1.5 px-4 flex items-center hover:text-white transition-colors duration-200">Backup
                        & Restore</a>
                </li>
            </ul>
        </li>
    </ul>
</div>
<div class="fixed top-0 left-0 w-full h-full bg-black/50 z-30 md:hidden sidebar-overlay hidden"></div>

