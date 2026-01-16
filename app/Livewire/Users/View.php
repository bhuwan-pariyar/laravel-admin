<?php

namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\User;

class View extends Component
{
    public $user;

    public function mount($userId)
    {
        $this->user = User::findOrFail($userId);
    }

    public function render()
    {
        return view('livewire.users.view');
    }
}
