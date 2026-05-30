<x-app-layout>
    <x-breadcrumb>
        <li><a href="{{ route('dashboard.index') }}"><i class="fa-solid fa-gauge"></i>&nbsp; Dashboard</a></li>
        <li><a href="{{ route('sales.list') }}"><i class="fa-solid fa-cart-shopping"></i>&nbsp; Sales</a></li>
        <li><a href="#">Invoice Details</a></li>
    </x-breadcrumb>
    <div class="px-5">
        @livewire('sales.view', ['saleId' => $saleId])
    </div>
</x-app-layout>
