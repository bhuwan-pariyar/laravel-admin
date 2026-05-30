<x-app-layout>
    <x-breadcrumb>
        <li><a href="{{ route('dashboard.index') }}"><i class="fa-solid fa-gauge"></i>&nbsp; Dashboard</a></li>
        <li><a href="#"><i class="fa-solid fa-shield-halved"></i>&nbsp; Roles & Permissions</a></li>
    </x-breadcrumb>
    <div class="px-5">
        @livewire('roles.roles-table')
    </div>
</x-app-layout>
