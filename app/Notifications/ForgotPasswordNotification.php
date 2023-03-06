<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ForgotPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;




    public string $token;

    public function __construct(string $token)
    {
        $this->queue = 'emails';
        $this->token = $token;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function makeResetUrl($email): string
    {
        return env('FRONTEND_URL').'/reset-password?token='.$this->token.'&email='.$email;
    }

    public function toMail($notifiable): MailMessage
    {
        $url = $this->makeResetUrl($notifiable->email);
        return (new MailMessage)
            ->line('Thank you for using our application!')
            ->from(env('MAIL_FROM_NAME'))
            ->action('Reset password', url($url));

    }
}
