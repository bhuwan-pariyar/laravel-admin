<x-app-layout>
    <x-breadcrumb>
        <li><a href="{{ route('dashboard.index') }}"><i class="fa-solid fa-gauge"></i>&nbsp; Dashboard</a></li>
        <li><a href="{{ route('settings.departments.list') }}"><i class="fa-solid fa-sitemap"></i>&nbsp; Departments</a></li>
        <li><a href="#"><i class="fa-solid fa-folder-plus"></i>&nbsp;
                {{ request()->route('departmentId') ? 'Edit Department' : 'Create Department' }}</a></li>
    </x-breadcrumb>
    <div class="px-5">
        <div class="px-5 py-3 bg-white rounded-1xl shadow-sm border border-slate-200 overflow-hidden">
            @livewire('settings.department-form', ['departmentId' => request()->route('departmentId')])
        </div>
    </div>
</x-app-layout>
