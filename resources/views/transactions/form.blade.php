<x-app-layout>
    <x-breadcrumb>
        <li><a href="{{ route('dashboard.index') }}"><i class="fa-solid fa-gauge"></i>&nbsp; Dashboard</a></li>
        <li><a href="{{ route('transactions.list') }}"><i class="fa-solid fa-list"></i>&nbsp; Transaction List</a></li>
        <li><a href="#"><i class="fa-solid fa-plus-circle"></i>&nbsp; Log Stock Transaction</a></li>
    </x-breadcrumb>
    <div class="px-5">
        <div class="px-5 py-5 bg-white rounded-1xl shadow-sm border border-slate-200 overflow-hidden">
            @livewire('stock-transactions.form')
        </div>
    </div>
</x-app-layout>
