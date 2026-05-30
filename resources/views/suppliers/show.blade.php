<x-app-layout>
    <x-breadcrumb>
        <li><a href="{{ route('dashboard.index') }}"><i class="fa-solid fa-gauge"></i>&nbsp; Dashboard</a></li>
        <li><a href="{{ route('suppliers.list') }}"><i class="fa-solid fa-list"></i>&nbsp; Supplier List</a></li>
        <li><a href="#"><i class="fa-solid fa-info-circle"></i>&nbsp; Supplier Details</a></li>
    </x-breadcrumb>
    <div class="px-5">
        <div class="px-5 py-5 bg-white rounded-1xl shadow-sm border border-slate-200 overflow-hidden">
            @livewire('suppliers.view', ['supplierId' => request()->route('supplierId')])
        </div>
    </div>
</x-app-layout>
