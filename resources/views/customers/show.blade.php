<x-app-layout>
    <x-breadcrumb>
        <li><a href="{{ route('dashboard.index') }}"><i class="fa-solid fa-gauge"></i>&nbsp; Dashboard</a></li>
        <li><a href="{{ route('customers.list') }}"><i class="fa-solid fa-users"></i>&nbsp; Customer List</a></li>
        <li><a href="#"><i class="fa-solid fa-info-circle"></i>&nbsp; Customer Details</a></li>
    </x-breadcrumb>
    <div class="px-5">
        <div class="px-5 py-1.5 bg-white rounded-1xl shadow-sm border border-slate-200 overflow-hidden">
            @livewire('customers.view', ['customerId' => request()->route('customerId')])
        </div>
    </div>
</x-app-layout>
