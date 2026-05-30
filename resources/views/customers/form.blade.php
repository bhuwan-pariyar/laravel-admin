<x-app-layout>
    <x-breadcrumb>
        <li><a href="{{ route('dashboard.index') }}"><i class="fa-solid fa-gauge"></i>&nbsp; Dashboard</a></li>
        <li><a href="{{ route('customers.list') }}"><i class="fa-solid fa-users"></i>&nbsp; Customers</a></li>
        <li><a href="#">{{ isset($customerId) ? 'Edit' : 'Create' }}</a></li>
    </x-breadcrumb>
    <div class="px-5">
        @livewire('customers.form', ['customerId' => $customerId ?? null])
    </div>
</x-app-layout>
