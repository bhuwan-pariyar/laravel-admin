<div class="py-2">
    @if (session()->has('message'))
        <div class="mb-4 p-4 rounded text-white bg-green-600">
            {{ session('message') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6 border-b pb-4 border-slate-100">
        <div>
            <h3 class="text-sm font-semibold text-slate-800">Database Backup Logs</h3>
            <p class="text-xs text-slate-500">Generate, download, or restore database backup files.</p>
        </div>
        <x-button variant="primary" size="sm" type="button" wire:click="generateBackup">
            <i class="fa-solid fa-plus mr-1"></i> Generate New Backup
        </x-button>
    </div>

    <!-- Backup List Table -->
    <div class="overflow-x-auto rounded-lg border border-slate-200">
        <table class="min-w-full divide-y divide-slate-200 bg-white">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">File Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">File Size</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Created At</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider w-40">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse ($backups as $backup)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-700">
                            <i class="fa-solid fa-file-code text-slate-400 mr-2"></i> {{ $backup['filename'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                            {{ $backup['size'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                            {{ $backup['date'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                {{ ucfirst($backup['status']) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex items-center justify-center gap-3">
                                <button type="button" wire:click="restoreBackup({{ $backup['id'] }})"
                                    wire:confirm="Are you sure you want to restore the system to this state? Current data changes will be overwritten."
                                    class="text-emerald-600 hover:text-emerald-900 flex items-center gap-1" title="Restore Backup">
                                    <i class="fa-solid fa-rotate-left"></i> Restore
                                </button>
                                <button type="button" wire:click="deleteBackup({{ $backup['id'] }})"
                                    wire:confirm="Are you sure you want to delete this backup file?"
                                    class="text-red-600 hover:text-red-900 flex items-center gap-1" title="Delete Backup">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-sm text-slate-500">
                            No backup files found. Click "Generate New Backup" to create one.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
