<?php

namespace Tests\Feature;

use App\Models\User;
use App\Livewire\NotificationCenter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SystemNotification;
use Livewire\Livewire;
use Tests\TestCase;

class NotificationCenterTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_mark_notification_as_read()
    {
        $user = User::factory()->create([
            'username' => 'testuser',
            'address' => '123 Test St',
        ]);

        $user->notify(new SystemNotification('Test Title', 'Test Message'));

        $notification = $user->unreadNotifications->first();
        $this->assertNotNull($notification);

        Livewire::actingAs($user)
            ->test(NotificationCenter::class)
            ->call('markAsRead', $notification->id)
            ->assertDispatched('toastr');

        $this->assertEquals(0, $user->fresh()->unreadNotifications()->count());
    }

    public function test_can_mark_all_notifications_as_read()
    {
        $user = User::factory()->create([
            'username' => 'testuser',
            'address' => '123 Test St',
        ]);

        $user->notify(new SystemNotification('Test Title 1', 'Test Message 1'));
        $user->notify(new SystemNotification('Test Title 2', 'Test Message 2'));

        $this->assertEquals(2, $user->unreadNotifications()->count());

        Livewire::actingAs($user)
            ->test(NotificationCenter::class)
            ->call('markAllAsRead')
            ->assertDispatched('toastr');

        $this->assertEquals(0, $user->fresh()->unreadNotifications()->count());
    }
}
