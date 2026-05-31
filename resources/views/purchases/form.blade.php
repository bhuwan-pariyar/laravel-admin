<x-app-layout>
    <x-breadcrumb>
        <li><a href="{{ route('dashboard.index') }}"><i class="fa-solid fa-gauge"></i>&nbsp; Dashboard</a></li>
        <li><a href="{{ route('purchases.list') }}"><i class="fa-solid fa-bag-shopping"></i>&nbsp; Purchases</a></li>
        <li><a href="#">{{ isset($purchaseId) ? 'Edit Purchase' : 'Record Purchase' }}</a></li>
    </x-breadcrumb>
    <div class="px-5">
        @livewire('purchases.form', ['purchaseId' => $purchaseId ?? null])
    </div>
</x-app-layout>
