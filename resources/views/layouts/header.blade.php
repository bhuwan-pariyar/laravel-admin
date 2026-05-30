<div
    class="py-2 px-6 bg-[var(--header-bg)] border-b border-[var(--header-border)] flex items-center shadow-md shadow-black/5 sticky top-0 left-0 z-30">
    <a href="#" class="flex items-center mr-3">
        <img id="logoExpanded" src="{{ asset('assets/images/LaraWire.png') }}" alt=""
            class="w-30 h-8 rounded object-cover">
        <img id="logoCollapsed" src="{{ asset('assets/images/LarawireLogo.png') }}" alt=""
            class="w-8 h-8 rounded object-cover hidden">
    </a>
    <!-- Sidebar Toggle Button -->
    <button id="sidebarToggle" type="button"
        class="relative flex items-center justify-center w-8 h-8 text-lg text-slate-600 dark:text-gray-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800 rounded transition-all duration-200 sidebar-toggle mr-3"
        title="Toggle Sidebar">
        <i id="sidebarIconIndent" class="fa-solid fa-indent transition-opacity duration-200 absolute"></i>
        <i id="sidebarIconOutdent" class="fa-solid fa-outdent transition-opacity duration-200 invisible absolute"></i>
    </button>

    <ul class="ml-auto flex items-center">
        <li class="mr-1">
            <livewire:header-search />
        </li>
        <li class="relative mr-2" x-data="{ 
            open: false, 
            theme: localStorage.getItem('color-theme') || 'system',
            setTheme(val) {
                this.theme = val;
                if (val === 'dark') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else if (val === 'light') {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    localStorage.removeItem('color-theme');
                    if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
                this.open = false;
            }
        }" @click.away="open = false">
            <button type="button" @click="open = !open"
                class="text-slate-600 dark:text-gray-300 w-8 h-8 rounded-full flex items-center justify-center hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-all duration-200"
                title="Change theme">
                <i class="fa-solid" :class="{
                    'fa-sun': theme === 'light',
                    'fa-moon': theme === 'dark',
                    'fa-circle-half-stroke': theme === 'system'
                }"></i>
            </button>
            <div x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                class="absolute right-0 mt-3 w-36 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-md shadow-xl z-50 overflow-hidden"
                style="display: none;">
                <div class="p-1 flex flex-col gap-0.5">
                    <button type="button" @click="setTheme('light')"
                        class="w-full text-left px-3 py-1.5 rounded-lg text-xs font-medium flex items-center gap-2 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                        :class="theme === 'light' ? 'text-indigo-600 dark:text-indigo-400 bg-slate-50 dark:bg-slate-800/60' : 'text-slate-700 dark:text-slate-300'">
                        <i class="fa-solid fa-sun w-4"></i> Light
                    </button>
                    <button type="button" @click="setTheme('dark')"
                        class="w-full text-left px-3 py-1.5 rounded-lg text-xs font-medium flex items-center gap-2 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                        :class="theme === 'dark' ? 'text-indigo-600 dark:text-indigo-400 bg-slate-50 dark:bg-slate-800/60' : 'text-slate-700 dark:text-slate-300'">
                        <i class="fa-solid fa-moon w-4"></i> Dark
                    </button>
                    <button type="button" @click="setTheme('system')"
                        class="w-full text-left px-3 py-1.5 rounded-lg text-xs font-medium flex items-center gap-2 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                        :class="theme === 'system' ? 'text-indigo-600 dark:text-indigo-400 bg-slate-50 dark:bg-slate-800/60' : 'text-slate-700 dark:text-slate-300'">
                        <i class="fa-solid fa-circle-half-stroke w-4"></i> System
                    </button>
                </div>
            </div>
        </li>
        <li class="mr-1">
            <livewire:notification-center />
        </li>
        <li class="dropdown ml-3">
            <button type="button"
                class="dropdown-toggle text-slate-600 dark:text-gray-300 w-8 h-8 rounded flex items-center justify-center hover:bg-slate-100 dark:hover:bg-slate-800 group">
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
