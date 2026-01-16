<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\User;

class Delete extends Component
{
    public $user;
    public $confirmText = '';

    public function mount($userId)
    {
        $this->user = User::findOrFail($userId);
    }

    public function delete()
    {
        // Optional: Add confirmation check
        if ($this->confirmText !== 'DELETE') {
            $this->addError('confirmText', 'Please type DELETE to confirm.');
            return;
        }

        $userName = $this->user->name;

        $this->user->delete();

        $this->dispatch('closeModal');
        $this->dispatch('itemDeleted');

        session()->flash('success', "User '{$userName}' has been deleted successfully.");
    }

    public function render()
    {
        return view('livewire.users.delete');
    }
}
