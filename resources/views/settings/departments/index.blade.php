<x-app-layout>
    <x-breadcrumb>
        <li><a href="{{ route('dashboard.index') }}"><i class="fa-solid fa-gauge"></i>&nbsp; Dashboard</a></li>
        <li><a href="#"><i class="fa-solid fa-gear"></i>&nbsp; Settings</a></li>
        <li><a href="#"><i class="fa-solid fa-sitemap"></i>&nbsp; Departments</a></li>
    </x-breadcrumb>
    <div class="px-5">
        @livewire('settings.departments-table')
    </div>
</x-app-layout>
