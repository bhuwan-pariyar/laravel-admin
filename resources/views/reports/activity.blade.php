<x-app-layout>
    <x-breadcrumb>
        <li><a href="{{ route('dashboard.index') }}"><i class="fa-solid fa-gauge"></i>&nbsp; Dashboard</a></li>
        <li><a href="#"><i class="fa-solid fa-history"></i>&nbsp; Analytics</a></li>
        <li><a href="#">Activity Report</a></li>
    </x-breadcrumb>
    <div class="px-5">
        @livewire('reports.activity-report')
    </div>
</x-app-layout>
