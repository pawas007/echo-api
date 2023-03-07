<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public string $token;
    public function __construct($token)
    {
        $this->token = $token;
        $this->queue = 'emails';
    }

    public function makeVerifyUrl($email): string
    {
        return env('FRONTEND_URL').'/verify-email?token='.$this->token.'&email='.$email;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $url = $this->makeVerifyUrl($notifiable->email);
        return (new MailMessage)
            ->from(env('MAIL_FROM_NAME'))
            ->action('Verify Email', $url)
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
