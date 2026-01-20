<x-app-layout>
    <x-breadcrumb>
        <li><a href="{{ route('dashboard.index') }}"><i class="fa-solid fa-gauge"></i>&nbsp; Dashboard</a></li>
        <li><a href="{{ route('users.list') }}"><i class="fa-solid fa-list"></i>&nbsp; User List</a></li>
        <li><a href="#"><i class="fa-solid fa-user-plus"></i>&nbsp;
                {{ request()->route('userId') ? 'Edit User' : 'Create User' }}</a></li>
    </x-breadcrumb>
    <div class="px-5">
        <div class="px-5 py-1.5 bg-white rounded-1xl shadow-sm border border-slate-200 overflow-hidden">
            @livewire('users.form', ['userId' => request()->route('userId')])
        </div>
    </div>
</x-app-layout>
