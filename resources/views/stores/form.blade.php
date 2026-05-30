<x-app-layout>
    <x-breadcrumb>
        <li><a href="{{ route('dashboard.index') }}"><i class="fa-solid fa-gauge"></i>&nbsp; Dashboard</a></li>
        <li><a href="{{ route('stores.list') }}"><i class="fa-solid fa-store"></i>&nbsp; Stores</a></li>
        <li><a href="#">{{ isset($storeId) ? 'Edit' : 'Create' }}</a></li>
    </x-breadcrumb>
    <div class="px-5">
        @livewire('stores.form', ['storeId' => $storeId ?? null])
    </div>
</x-app-layout>
