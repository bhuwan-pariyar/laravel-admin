<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SystemNotification extends Notification
{
    use Queueable;

    protected $title;
    protected $message;
    protected $type;
    protected $icon;
    protected $actionUrl;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $title, string $message, string $type = 'info', string $icon = 'fa-solid fa-bell', ?string $actionUrl = null)
    {
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
        $this->icon = $icon;
        $this->actionUrl = $actionUrl;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'type' => $this->type,
            'icon' => $this->icon,
            'action_url' => $this->actionUrl,
        ];
    }
}
