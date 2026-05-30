<x-app-layout>
    <x-breadcrumb>
        <li><a href="{{ route('dashboard.index') }}"><i class="fa-solid fa-gauge"></i>&nbsp; Dashboard</a></li>
        <li><a href="#"><i class="fa-solid fa-exchange-alt"></i>&nbsp; Stock Transactions</a></li>
    </x-breadcrumb>
    <div class="px-5">
        @livewire('stock-transactions.stock-transactions-table')
    </div>
</x-app-layout>
