<div id="sidebar"
    class="fixed left-0 top-12 h-[calc(100vh-3rem)] bg-slate-900 dark:bg-slate-900 p-3 z-40 sidebar-menu transition-all">
    <ul class="mt-4 space-y-1 list-none px-1">
        <li class="group no-children {{ active_menu(['dashboard']) }}">
            <a href="{{ route('dashboard.index') }}" data-tooltip="Dashboard"
                class="flex items-center py-1.5 px-3 text-slate-300 hover:bg-slate-800/60 hover:text-white group-[.active]:bg-slate-800 group-[.active]:text-indigo-400 group-[.active]:border-l-2 group-[.active]:border-indigo-500 rounded-lg transition-all duration-200">
                <i class="fa-solid fa-gauge mr-3 text-[13px] opacity-80 group-[.active]:opacity-100 transition-opacity"></i>
                <span class="text-[12px] font-medium tracking-wide">Dashboard</span>
            </a>
        </li>

        <!-- Master Data -->
        <li class="px-3 pt-3 pb-1 text-slate-500 text-[9px] uppercase font-bold tracking-wider opacity-60">Master Data</li>

        @can('view categories')
        <li class="group no-children {{ active_menu(['categories*']) }}">
            <a href="{{ route('categories.list') }}" data-tooltip="Categories"
                class="flex items-center py-1.5 px-3 text-slate-300 hover:bg-slate-800/60 hover:text-white group-[.active]:bg-slate-800 group-[.active]:text-indigo-400 group-[.active]:border-l-2 group-[.active]:border-indigo-500 rounded-lg transition-all duration-200">
                <i class="fa-solid fa-layer-group mr-3 text-[13px] opacity-80 group-[.active]:opacity-100 transition-opacity"></i>
                <span class="text-[12px] font-medium tracking-wide">Categories</span>
            </a>
        </li>
        @endcan

        @can('view items')
        <li class="group no-children {{ active_menu(['items*']) }}">
            <a href="{{ route('items.list') }}" data-tooltip="Items"
                class="flex items-center py-1.5 px-3 text-slate-300 hover:bg-slate-800/60 hover:text-white group-[.active]:bg-slate-800 group-[.active]:text-indigo-400 group-[.active]:border-l-2 group-[.active]:border-indigo-500 rounded-lg transition-all duration-200">
                <i class="fa-solid fa-boxes mr-3 text-[13px] opacity-80 group-[.active]:opacity-100 transition-opacity"></i>
                <span class="text-[12px] font-medium tracking-wide">Items</span>
            </a>
        </li>
        @endcan

        @can('view suppliers')
        <li class="group no-children {{ active_menu(['suppliers*']) }}">
            <a href="{{ route('suppliers.list') }}" data-tooltip="Suppliers"
                class="flex items-center py-1.5 px-3 text-slate-300 hover:bg-slate-800/60 hover:text-white group-[.active]:bg-slate-800 group-[.active]:text-indigo-400 group-[.active]:border-l-2 group-[.active]:border-indigo-500 rounded-lg transition-all duration-200">
                <i class="fa-solid fa-truck-field mr-3 text-[13px] opacity-80 group-[.active]:opacity-100 transition-opacity"></i>
                <span class="text-[12px] font-medium tracking-wide">Suppliers</span>
            </a>
        </li>
        @endcan

        @can('view customers')
        <li class="group no-children {{ active_menu(['customers*']) }}">
            <a href="{{ route('customers.list') }}" data-tooltip="Customers"
                class="flex items-center py-1.5 px-3 text-slate-300 hover:bg-slate-800/60 hover:text-white group-[.active]:bg-slate-800 group-[.active]:text-indigo-400 group-[.active]:border-l-2 group-[.active]:border-indigo-500 rounded-lg transition-all duration-200">
                <i class="fa-solid fa-users mr-3 text-[13px] opacity-80 group-[.active]:opacity-100 transition-opacity"></i>
                <span class="text-[12px] font-medium tracking-wide">Customers</span>
            </a>
        </li>
        @endcan

        @can('view stores')
        <li class="group no-children {{ active_menu(['stores*']) }}">
            <a href="{{ route('stores.list') }}" data-tooltip="Stores"
                class="flex items-center py-1.5 px-3 text-slate-300 hover:bg-slate-800/60 hover:text-white group-[.active]:bg-slate-800 group-[.active]:text-indigo-400 group-[.active]:border-l-2 group-[.active]:border-indigo-500 rounded-lg transition-all duration-200">
                <i class="fa-solid fa-store mr-3 text-[13px] opacity-80 group-[.active]:opacity-100 transition-opacity"></i>
                <span class="text-[12px] font-medium tracking-wide">Stores</span>
            </a>
        </li>
        @endcan

        <!-- Operations -->
        <li class="px-3 pt-3 pb-1 text-slate-500 text-[9px] uppercase font-bold tracking-wider opacity-60">Operations</li>

        @can('view sales')
        <li class="group no-children {{ active_menu(['sales*']) }}">
            <a href="{{ route('sales.list') }}" data-tooltip="Sales"
                class="flex items-center py-1.5 px-3 text-slate-300 hover:bg-slate-800/60 hover:text-white group-[.active]:bg-slate-800 group-[.active]:text-indigo-400 group-[.active]:border-l-2 group-[.active]:border-indigo-500 rounded-lg transition-all duration-200">
                <i class="fa-solid fa-cart-shopping mr-3 text-[13px] opacity-80 group-[.active]:opacity-100 transition-opacity"></i>
                <span class="text-[12px] font-medium tracking-wide">Sales</span>
            </a>
        </li>
        @endcan

        @can('view purchases')
        <li class="group no-children {{ active_menu(['purchases*']) }}">
            <a href="{{ route('purchases.list') }}" data-tooltip="Purchases"
                class="flex items-center py-1.5 px-3 text-slate-300 hover:bg-slate-800/60 hover:text-white group-[.active]:bg-slate-800 group-[.active]:text-indigo-400 group-[.active]:border-l-2 group-[.active]:border-indigo-500 rounded-lg transition-all duration-200">
                <i class="fa-solid fa-bag-shopping mr-3 text-[13px] opacity-80 group-[.active]:opacity-100 transition-opacity"></i>
                <span class="text-[12px] font-medium tracking-wide">Purchases</span>
            </a>
        </li>
        @endcan

        @can('view transfers')
        <li class="group no-children {{ active_menu(['transfers*']) }}">
            <a href="{{ route('transfers.list') }}" data-tooltip="Transfers"
                class="flex items-center py-1.5 px-3 text-slate-300 hover:bg-slate-800/60 hover:text-white group-[.active]:bg-slate-800 group-[.active]:text-indigo-400 group-[.active]:border-l-2 group-[.active]:border-indigo-500 rounded-lg transition-all duration-200">
                <i class="fa-solid fa-truck-ramp-box mr-3 text-[13px] opacity-80 group-[.active]:opacity-100 transition-opacity"></i>
                <span class="text-[12px] font-medium tracking-wide">Transfers</span>
            </a>
        </li>
        @endcan

        @can('view damage')
        <li class="group no-children {{ active_menu(['damage*']) }}">
            <a href="{{ route('damage.list') }}" data-tooltip="Report Damage"
                class="flex items-center py-1.5 px-3 text-slate-300 hover:bg-slate-800/60 hover:text-white group-[.active]:bg-blue-600 group-[.active]:text-white rounded-lg transition-all duration-200">
                <i class="fa-solid fa-house-damage mr-3 text-[13px] opacity-80 group-[.active]:opacity-100 transition-opacity"></i>
                <span class="text-[12px] font-medium tracking-wide">Report Damage</span>
            </a>
        </li>
        @endcan

        @can('generate qr')
        <li class="group no-children {{ active_menu(['qr*']) }}">
            <a href="{{ route('qr.index') }}" data-tooltip="Generate QR"
                class="flex items-center py-1.5 px-3 text-slate-300 hover:bg-slate-800/60 hover:text-white group-[.active]:bg-blue-600 group-[.active]:text-white rounded-lg transition-all duration-200">
                <i class="fa-solid fa-qrcode mr-3 text-[13px] opacity-80 group-[.active]:opacity-100 transition-opacity"></i>
                <span class="text-[12px] font-medium tracking-wide">Generate QR Code</span>
            </a>
        </li>
        @endcan

        <!-- Reports -->
        @can('view reports')
        <li class="px-3 pt-3 pb-1 text-slate-500 text-[9px] uppercase font-bold tracking-wider opacity-60">Analytics</li>
        <li class="group no-children {{ active_menu(['reports/stock*']) }}">
            <a href="{{ route('reports.stock') }}" data-tooltip="Stock Report"
                class="flex items-center py-1.5 px-3 text-slate-300 hover:bg-slate-800/60 hover:text-white group-[.active]:bg-blue-600 group-[.active]:text-white rounded-lg transition-all duration-200">
                <i class="fa-solid fa-chart-line mr-3 text-[13px] opacity-80 group-[.active]:opacity-100 transition-opacity"></i>
                <span class="text-[12px] font-medium tracking-wide">Stock Report</span>
            </a>
        </li>
        <li class="group no-children {{ active_menu(['reports/activity*']) }}">
            <a href="{{ route('reports.activity') }}" data-tooltip="Activity Report"
                class="flex items-center py-1.5 px-3 text-slate-300 hover:bg-slate-800/60 hover:text-white group-[.active]:bg-blue-600 group-[.active]:text-white rounded-lg transition-all duration-200">
                <i class="fa-solid fa-history mr-3 text-[13px] opacity-80 group-[.active]:opacity-100 transition-opacity"></i>
                <span class="text-[12px] font-medium tracking-wide">Activity Report</span>
            </a>
        </li>
        @endcan

        <li class="px-3 pt-3 pb-1 text-slate-500 text-[9px] uppercase font-bold tracking-wider opacity-60">System</li>
        <li class="group has-children {{ active_menu(['settings*', 'roles*', 'users*']) }}">
            <a href="#"
                class="flex items-center py-1.5 px-3 text-slate-300 hover:bg-slate-800/60 hover:text-white group-[.active]:bg-slate-800 group-[.active]:text-white group-[.selected]:bg-slate-800/80 group-[.selected]:text-white sidebar-dropdown-toggle rounded-lg transition-all duration-200">
                <i class="fa-solid fa-gear mr-3 text-[13px] opacity-80 transition-opacity"></i>
                <span class="text-[12px] font-medium tracking-wide">Settings</span>
                <i
                    class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90 transition-transform duration-200"></i>
            </a>
            <ul class="hidden group-[.selected]:block list-none mt-1 space-y-1 pl-4" data-parent-title="Settings">
                <li>
                    <a href="{{ route('settings.index') }}"
                        class="text-slate-400 text-[11px] font-medium py-1 px-3 flex items-center hover:text-white transition-colors duration-200">Company
                        Profile</a>
                </li>
                <li>
                    <a href="{{ route('settings.departments.list') }}"
                        class="text-slate-400 text-[11px] font-medium py-1 px-3 flex items-center hover:text-white transition-colors duration-200">Departments</a>
                </li>
                @can('view users')
                <li>
                    <a href="{{ route('users.list') }}"
                        class="text-slate-400 text-[11px] font-medium py-1 px-3 flex items-center hover:text-white transition-colors duration-200">Users</a>
                </li>
                @endcan
                @can('view roles')
                <li>
                    <a href="{{ route('roles.list') }}"
                        class="text-slate-400 text-[11px] font-medium py-1 px-3 flex items-center hover:text-white transition-colors duration-200">Roles & Permissions</a>
                </li>
                @endcan
                <li>
                    <a href="{{ route('settings.email') }}"
                        class="text-slate-400 text-[11px] font-medium py-1 px-3 flex items-center hover:text-white transition-colors duration-200">Email</a>
                </li>
                <li>
                    <a href="{{ route('settings.backup') }}"
                        class="text-slate-400 text-[11px] font-medium py-1 px-3 flex items-center hover:text-white transition-colors duration-200">Backup
                        & Restore</a>
                </li>
            </ul>
        </li>
    </ul>
</div>
<div class="fixed top-0 left-0 w-full h-full bg-black/50 z-30 md:hidden sidebar-overlay hidden"></div>

