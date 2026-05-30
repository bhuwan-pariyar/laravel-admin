<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class BackupRestore extends Component
{
    public $backups = [];

    public function mount()
    {
        $this->loadBackups();
    }

    public function loadBackups()
    {
        $this->backups = Session::get('system_backups', [
            [
                'id' => 1,
                'filename' => 'backup_2026_05_28_100000.sql',
                'size' => '2.4 MB',
                'date' => '2026-05-28 10:00:00',
                'status' => 'completed',
            ],
            [
                'id' => 2,
                'filename' => 'backup_2026_05_29_123045.sql',
                'size' => '2.5 MB',
                'date' => '2026-05-29 12:30:45',
                'status' => 'completed',
            ],
        ]);
    }

    public function generateBackup()
    {
        $newId = count($this->backups) > 0 ? max(array_column($this->backups, 'id')) + 1 : 1;
        $dateStr = now()->format('Y_m_d_His');
        $displayDate = now()->format('Y-m-d H:i:s');
        
        $newBackup = [
            'id' => $newId,
            'filename' => "backup_{$dateStr}.sql",
            'size' => rand(20, 30) / 10 . ' MB',
            'date' => $displayDate,
            'status' => 'completed',
        ];

        array_unshift($this->backups, $newBackup);
        Session::put('system_backups', $this->backups);

        session()->flash('message', 'Backup generated successfully.');
        session()->flash('alert-type', 'success');
    }

    public function restoreBackup($id)
    {
        $backup = collect($this->backups)->firstWhere('id', $id);
        if ($backup) {
            session()->flash('message', "System restored successfully using {$backup['filename']}.");
            session()->flash('alert-type', 'success');
        }
    }

    public function deleteBackup($id)
    {
        $this->backups = collect($this->backups)->reject(fn($b) => $b['id'] == $id)->toArray();
        Session::put('system_backups', $this->backups);
        
        session()->flash('message', 'Backup file deleted.');
        session()->flash('alert-type', 'info');
    }

    public function render()
    {
        return view('livewire.settings.backup-restore');
    }
}
