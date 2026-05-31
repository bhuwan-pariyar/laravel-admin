<x-app-layout>
    <x-breadcrumb>
        <li><a href="{{ route('dashboard.index') }}"><i class="fa-solid fa-gauge"></i>&nbsp; Dashboard</a></li>
        <li><a href="{{ route('settings.departments.list') }}"><i class="fa-solid fa-building"></i>&nbsp; Department List</a></li>
        <li><a href="#"><i class="fa-solid fa-info-circle"></i>&nbsp; Department Details</a></li>
    </x-breadcrumb>
    <div class="px-5">
        <div class="px-5 py-1.5 bg-white dark:bg-slate-900 rounded-1xl shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden">
            @livewire('settings.department-view', ['departmentId' => request()->route('departmentId')])
        </div>
    </div>
</x-app-layout>
