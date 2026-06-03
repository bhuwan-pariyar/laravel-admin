<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;

class NotificationCenter extends Component
{
    #[Computed]
    public function notifications()
    {
        return auth()->check() 
            ? auth()->user()->notifications()->take(10)->get() 
            : collect();
    }

    #[Computed]
    public function unreadCount()
    {
        return auth()->check() 
            ? auth()->user()->unreadNotifications()->count() 
            : 0;
    }

    public function markAllAsRead()
    {
        if (auth()->check()) {
            auth()->user()->unreadNotifications()->update(['read_at' => now()]);
            unset($this->notifications);
            unset($this->unreadCount);
            $this->dispatch('toastr', message: 'All notifications marked as read', type: 'success');
        }
    }

    public function markAsRead($id)
    {
        if (auth()->check()) {
            $notification = auth()->user()->unreadNotifications()->find($id);
            if ($notification) {
                $notification->markAsRead();
                unset($this->notifications);
                unset($this->unreadCount);
                $this->dispatch('toastr', message: 'Notification marked as read', type: 'success');
            }
        }
    }

    public function render()
    {
        return view('livewire.notification-center');
    }
}

