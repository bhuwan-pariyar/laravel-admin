<x-app-layout>
    <x-breadcrumb>
        <li><a href="{{ route('dashboard.index') }}"><i class="fa-solid fa-gauge"></i>&nbsp; Dashboard</a></li>
        <li><a href="#"><i class="fa-solid fa-chart-line"></i>&nbsp; Analytics</a></li>
        <li><a href="#">Stock Report</a></li>
    </x-breadcrumb>
    <div class="px-5">
        @livewire('reports.stock-report')
    </div>
</x-app-layout>
