<x-app-layout>
    <x-breadcrumb>
        <li><a href="{{ route('dashboard.index') }}"><i class="fa-solid fa-gauge"></i>&nbsp; Dashboard</a></li>
        <li><a href="#"><i class="fa-solid fa-truck"></i>&nbsp; Suppliers</a></li>
    </x-breadcrumb>
    <div class="px-5">
        @livewire('suppliers.suppliers-table')
    </div>
</x-app-layout>
