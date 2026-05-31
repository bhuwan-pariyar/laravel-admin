<x-app-layout>
    <x-breadcrumb>
        <li><a href="{{ route('dashboard.index') }}"><i class="fa-solid fa-gauge"></i>&nbsp; Dashboard</a></li>
        <li><a href="#"><i class="fa-solid fa-file-export"></i>&nbsp; Reports</a></li>
    </x-breadcrumb>
    <div class="px-5">
        @livewire('reports.report-export')
    </div>
</x-app-layout>
