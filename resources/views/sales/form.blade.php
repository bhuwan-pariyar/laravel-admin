<x-app-layout>
    <x-breadcrumb>
        <li><a href="{{ route('dashboard.index') }}"><i class="fa-solid fa-gauge"></i>&nbsp; Dashboard</a></li>
        <li><a href="{{ route('sales.list') }}"><i class="fa-solid fa-cart-shopping"></i>&nbsp; Sales</a></li>
        <li><a href="#">{{ isset($saleId) ? 'Edit Invoice' : 'Create Invoice' }}</a></li>
    </x-breadcrumb>
    <div class="px-5">
        @livewire('sales.form', ['saleId' => $saleId ?? null])
    </div>
</x-app-layout>
