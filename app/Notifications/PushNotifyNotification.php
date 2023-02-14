<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;
use App\Models\{User};
use Auth;

class PushNotifyNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public User $user;
    public string $action;
    public string $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, string $action,string $message)
    {
        $this->user = $user;
        $this->action = $action;
        $this->message = $message;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        return ['database', 'broadcast'];
    }


    public function toArray($notifiable): array
    {
        return [
            'action' =>$this->action,
            'message' =>$this->message,
            'user' => ['name' => $this->user->name],

        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        $notification = [
            "data" => [
                "action" => $this->action,
                'message' =>$this->message,
                "created" => now(),
                "user" => ['name' => $this->user->name],
            ]
        ];

        return new BroadcastMessage($notification);
    }
}
