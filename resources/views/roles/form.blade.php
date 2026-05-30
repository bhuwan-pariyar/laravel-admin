<x-app-layout>
    <x-breadcrumb>
        <li><a href="{{ route('dashboard.index') }}"><i class="fa-solid fa-gauge"></i>&nbsp; Dashboard</a></li>
        <li><a href="{{ route('roles.list') }}"><i class="fa-solid fa-list"></i>&nbsp; Role List</a></li>
        <li><a href="#"><i class="fa-solid fa-user-shield"></i>&nbsp;
                {{ request()->route('roleId') ? 'Edit Role' : 'Create Role' }}</a></li>
    </x-breadcrumb>
    <div class="px-5">
        <div class="px-5 py-5 bg-white rounded-1xl shadow-sm border border-slate-200 overflow-hidden">
            @livewire('roles.form', ['roleId' => request()->route('roleId')])
        </div>
    </div>
</x-app-layout>
