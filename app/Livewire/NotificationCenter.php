<?php

namespace App\Livewire;

use Livewire\Component;

class NotificationCenter extends Component
{
    public function getNotificationsProperty()
    {
        return auth()->check() 
            ? auth()->user()->notifications()->take(10)->get() 
            : collect();
    }

    public function getUnreadCountProperty()
    {
        return auth()->check() 
            ? auth()->user()->unreadNotifications()->count() 
            : 0;
    }

    public function markAllAsRead()
    {
        if (auth()->check()) {
            auth()->user()->unreadNotifications->markAsRead();
            $this->dispatch('toastr', message: 'All notifications marked as read', type: 'success');
        }
    }

    public function markAsRead($id)
    {
        if (auth()->check()) {
            $notification = auth()->user()->notifications()->find($id);
            if ($notification) {
                $notification->markAsRead();
                $this->dispatch('toastr', message: 'Notification marked as read', type: 'success');
            }
        }
    }

    public function render()
    {
        return view('livewire.notification-center');
    }
}
