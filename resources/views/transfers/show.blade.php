<x-app-layout>
    <x-breadcrumb>
        <li><a href="{{ route('dashboard.index') }}"><i class="fa-solid fa-gauge"></i>&nbsp; Dashboard</a></li>
        <li><a href="{{ route('transfers.list') }}"><i class="fa-solid fa-truck-ramp-box"></i>&nbsp; Transfers</a></li>
        <li><a href="#">Transfer Details</a></li>
    </x-breadcrumb>
    <div class="px-5">
        @livewire('transfers.view', ['transferId' => $transferId])
    </div>
</x-app-layout>
