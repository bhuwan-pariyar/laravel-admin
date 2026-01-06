<style>
    /* Sidebar transitions */
    .sidebar-menu {
        width: 11rem;
        transition: width 0.3s ease, transform 0.3s ease;
        overflow: visible;
        position: fixed;
        left: 0;
        top: 3rem;
        height: calc(100vh - 3rem);
        z-index: 40;
    }

    /* Collapsed state - shows only icons */
    .sidebar-menu.collapsed {
        width: 4rem;
    }

    /* Base link styling */
    .sidebar-menu ul li.group>a {
        position: relative;
        border-left: 3px solid transparent;
        color: rgb(209 213 219);
        background-color: transparent;
    }

    /* Active/selected (expanded) */
    .sidebar-menu ul li.group.active>a,
    .sidebar-menu ul li.group.selected>a {
        background-color: rgb(30 41 59);
        color: rgb(255 255 255);
        border-left-color: rgb(59 130 246);
    }

    /* Hover */
    .sidebar-menu ul li.group>a:hover {
        background-color: rgb(15 23 42);
        color: rgb(255 255 255);
    }

    /* Collapsed state - shows only icons */
    .sidebar-menu.collapsed ul li.group>a {
        justify-content: center;
        padding: 0.5rem;
        border-left-color: transparent;
    }

    /* Keep active highlight visible when collapsed */
    .sidebar-menu.collapsed ul li.group.active>a,
    .sidebar-menu.collapsed ul li.group.selected>a {
        background-color: rgb(30 41 59);
        color: rgb(255 255 255);
        border-left-color: rgb(59 130 246);
    }

    .sidebar-menu.collapsed ul li.group>a i:first-child {
        margin-right: 0;
    }

    /* Hide text when collapsed */
    .sidebar-menu.collapsed .text-xs {
        display: none;
    }

    /* Hide dropdown arrows when collapsed */
    .sidebar-menu.collapsed .ri-arrow-right-s-line {
        display: none;
    }

    /* Hide submenu by default when collapsed */
    .sidebar-menu.collapsed ul li.group ul {
        display: none !important;
    }

    /* Hover menu styles for collapsed sidebar */
    .sidebar-menu.collapsed ul li.group {
        position: relative;
    }

    /* Tooltip for items without children - collapsed */
    .sidebar-menu.collapsed ul li.group.no-children>a::after {
        content: attr(data-tooltip);
        position: fixed;
        left: 4rem;
        background-color: rgb(30 41 59);
        color: rgb(229 231 235);
        padding: 0.5rem 0.75rem;
        /* border-radius: 0.375rem; */
        font-size: 0.813rem;
        white-space: nowrap;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
        z-index: 100;
        border: 1px solid rgb(51 65 85);
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.2s ease, visibility 0.2s ease;
        pointer-events: none;
    }

    .sidebar-menu.collapsed ul li.group.no-children:hover>a::after,
    .sidebar-menu.collapsed ul li.group.no-children.show-tooltip>a::after {
        opacity: 1;
        visibility: visible;
        transition-delay: 0.1s;
    }

    /* Highlight icon on hover */
    .sidebar-menu.collapsed ul li.group:hover>a {
        background-color: rgb(15 23 42);
    }

    /* Popup container - improved positioning and interaction */
    .sidebar-menu.collapsed ul li.group.has-children {
        position: relative;
    }

    /* Popup for collapsed state */
    .sidebar-menu.collapsed ul li.group.has-children>ul {
        position: fixed;
        left: 4rem;
        background-color: rgb(30 41 59);
        min-width: 14rem;
        /* border-radius: 0.375rem; */
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
        padding: 0;
        z-index: 100;
        border: 1px solid rgb(51 65 85);
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transition: opacity 0.2s ease, visibility 0.2s ease;
        margin-top: 0;
        top: 0;
        transform: translateY(0);
    }

    /* Show popup when parent is hovered or has show-popup class - collapsed */
    .sidebar-menu.collapsed ul li.group.has-children:hover>ul,
    .sidebar-menu.collapsed ul li.group.has-children.show-popup>ul,
    .sidebar-menu.collapsed ul li.group.has-children>ul:hover {
        display: block !important;
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
    }

    /* Parent label section at top - collapsed state */
    .sidebar-menu.collapsed ul li.group.has-children>ul::before {
        content: attr(data-parent-title);
        display: block;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        font-weight: 600;
        color: rgb(229 231 235);
        background-color: rgb(51 65 85);
        /* border-radius: 0.375rem 0.375rem 0 0; */
        border-bottom: 1px solid rgb(71 85 105);
    }

    /* Children list styling - collapsed state */
    .sidebar-menu.collapsed ul li.group.has-children>ul li {
        margin-bottom: 0;
        padding: 0;
        list-style: none;
    }

    .sidebar-menu.collapsed ul li.group.has-children>ul li a {
        padding: 0.75rem 1rem;
        display: block;
        font-size: 0.813rem;
        color: rgb(209 213 219);
        text-decoration: none;
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
    }

    .sidebar-menu.collapsed ul li.group.has-children>ul li:last-child a {
        /* border-radius: 0 0 0.375rem 0.375rem; */
    }

    .sidebar-menu.collapsed ul li.group.has-children>ul li a:hover {
        background-color: rgb(51 65 85);
        color: rgb(255 255 255);
        border-left-color: rgb(59 130 246);
        padding-left: 1.25rem;
    }

    /* Remove default before pseudo element for children */
    .sidebar-menu.collapsed ul li.group.has-children>ul li a::before {
        display: none;
    }

    /* Adjust main content */
    .main {
        margin-left: 11rem;
        width: calc(100% - 11rem);
        transition: margin-left 0.3s ease, width 0.3s ease;
    }

    .main.collapsed {
        margin-left: 4rem;
        width: calc(100% - 4rem);
    }

    /* Icon sizing */
    .sidebar-menu i {
        min-width: 1.25rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    /* Improve hover states */
    .sidebar-menu ul li.group>a {
        transition: all 0.2s ease;
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .sidebar-menu {
            transform: translateX(-100%);
        }

        .sidebar-menu.active {
            transform: translateX(0);
        }

        .main {
            margin-left: 0;
            width: 100%;
        }

        .main.collapsed {
            margin-left: 0;
            width: 100%;
        }
    }
</style>

<div id="sidebar"
    class="fixed left-0 top-12 w-64 h-[calc(100vh-3rem)] bg-slate-900 dark:bg-slate-900 p-4 z-40 sidebar-menu transition-all">
    <ul class="mt-2">
        <li class="mb-1 group no-children {{ active_menu(['dashboard']) }}">
            <a href="{{ route('dashboard.index') }}" data-tooltip="Dashboard"
                class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100 transition-colors duration-200">
                <i class="fa-solid fa-gauge mr-3 text-lg"></i>
                <span class="text-xs">Dashboard</span>
            </a>
        </li>
        <li class="mb-1 group has-children">
            <a href="#"
                class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100 sidebar-dropdown-toggle transition-colors duration-200">
                <i class="ri-instance-line mr-3 text-lg"></i>
                <span class="text-xs">Orders</span>
                <i
                    class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90 transition-transform duration-200"></i>
            </a>
            <ul class="pl-7 mt-2 hidden group-[.selected]:block" data-parent-title="Orders">
                <li>
                    <a href="#"
                        class="text-gray-300 text-xs flex items-center hover:text-gray-100 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3 transition-colors duration-200">Active
                        order</a>
                </li>
                <li>
                    <a href="#"
                        class="text-gray-300 text-xs flex items-center hover:text-gray-100 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3 transition-colors duration-200">Completed
                        order</a>
                </li>
                <li>
                    <a href="#"
                        class="text-gray-300 text-xs flex items-center hover:text-gray-100 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3 transition-colors duration-200">Canceled
                        order</a>
                </li>
            </ul>
        </li>
        <li class="mb-1 group has-children">
            <a href="#"
                class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100 sidebar-dropdown-toggle transition-colors duration-200">
                <i class="ri-flashlight-line mr-3 text-lg"></i>
                <span class="text-xs">Services</span>
                <i
                    class="ri-arrow-right-s-line ml-auto group-[.selected]:rotate-90 transition-transform duration-200"></i>
            </a>
            <ul class="pl-7 mt-2 hidden group-[.selected]:block" data-parent-title="Services">
                <li>
                    <a href="#"
                        class="text-gray-300 text-xs flex items-center hover:text-gray-100 before:contents-[''] before:w-1 before:h-1 before:rounded-full before:bg-gray-300 before:mr-3 transition-colors duration-200">Manage
                        services</a>
                </li>
            </ul>
        </li>
        <li class="mb-1 group no-children {{ active_menu(['settings']) }}">
            <a href="{{ route('settings.index') }}" data-tooltip="Settings"
                class="flex items-center py-2 px-4 text-gray-300 hover:bg-gray-950 hover:text-gray-100 rounded-md group-[.active]:bg-gray-800 group-[.active]:text-white group-[.selected]:bg-gray-950 group-[.selected]:text-gray-100 transition-colors duration-200">
                <i class="fa-solid fa-gear mr-3 text-lg"></i>
                <span class="text-xs">Settings</span>
            </a>
        </li>
    </ul>
</div>
<div class="fixed top-0 left-0 w-full h-full bg-black/50 z-30 md:hidden sidebar-overlay hidden"></div>

@push('custom-scripts')
    <script>
        // Sidebar toggle functionality - handled in script.js
        // Popup behavior is also handled in script.js for consistency
    </script>
@endpush
