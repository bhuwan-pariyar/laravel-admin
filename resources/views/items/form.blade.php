<x-app-layout>
    <x-breadcrumb>
        <li><a href="{{ route('dashboard.index') }}"><i class="fa-solid fa-gauge"></i>&nbsp; Dashboard</a></li>
        <li><a href="{{ route('items.list') }}"><i class="fa-solid fa-list"></i>&nbsp; Item List</a></li>
        <li><a href="#"><i class="fa-solid fa-box-open"></i>&nbsp;
                {{ request()->route('itemId') ? 'Edit Item' : 'Create Item' }}</a></li>
    </x-breadcrumb>
    <div class="px-5">
        <div class="px-5 py-1.5 bg-white rounded-1xl shadow-sm border border-slate-200 overflow-hidden">
            @livewire('items.form', ['itemId' => request()->route('itemId')])
        </div>
    </div>
</x-app-layout>
