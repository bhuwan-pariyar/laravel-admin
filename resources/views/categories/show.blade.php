<x-app-layout>
    <x-breadcrumb>
        <li><a href="{{ route('dashboard.index') }}"><i class="fa-solid fa-gauge"></i>&nbsp; Dashboard</a></li>
        <li><a href="{{ route('categories.list') }}"><i class="fa-solid fa-list"></i>&nbsp; Category List</a></li>
        <li><a href="#"><i class="fa-solid fa-info-circle"></i>&nbsp; Category Details</a></li>
    </x-breadcrumb>
    <div class="px-5">
        <div class="px-5 py-1.5 bg-white rounded-1xl shadow-sm border border-slate-200 overflow-hidden">
            @livewire('categories.view', ['categoryId' => request()->route('categoryId')])
        </div>
    </div>
</x-app-layout>
