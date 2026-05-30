<x-app-layout>
    <x-breadcrumb>
        <li><a href="{{ route('dashboard.index') }}"><i class="fa-solid fa-gauge"></i>&nbsp; Dashboard</a></li>
        <li><a href="#"><i class="fa-solid fa-gear"></i>&nbsp; Settings</a></li>
        <li><a href="#"><i class="fa-solid fa-building"></i>&nbsp; Company Profile</a></li>
    </x-breadcrumb>
    <div class="px-5">
        <div class="px-5 py-3 bg-white rounded-1xl shadow-sm border border-slate-200 overflow-hidden">
            @livewire('settings.company-profile')
        </div>
    </div>
</x-app-layout>
