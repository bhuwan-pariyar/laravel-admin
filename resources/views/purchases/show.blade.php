<x-app-layout>
    <x-breadcrumb>
        <li><a href="{{ route('dashboard.index') }}"><i class="fa-solid fa-gauge"></i>&nbsp; Dashboard</a></li>
        <li><a href="{{ route('purchases.list') }}"><i class="fa-solid fa-bag-shopping"></i>&nbsp; Purchases</a></li>
        <li><a href="#">Purchase Order Details</a></li>
    </x-breadcrumb>
    <div class="px-5">
        @livewire('purchases.view', ['purchaseId' => $purchaseId])
    </div>
</x-app-layout>
