<x-app-layout>
    <x-breadcrumb>
        <li><a href="{{ route('dashboard.index') }}"><i class="fa-solid fa-gauge"></i>&nbsp; Dashboard</a></li>
        <li><a href="#"><i class="fa-solid fa-qrcode"></i>&nbsp; Items</a></li>
        <li><a href="#">Generate QR Code</a></li>
    </x-breadcrumb>
    <div class="px-5">
        @livewire('qr.qr-generator')
    </div>
</x-app-layout>
