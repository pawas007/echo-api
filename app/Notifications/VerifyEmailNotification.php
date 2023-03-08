<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class VerifyEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;


    public function __construct()
    {
        $this->queue = 'emails';
    }

    public function initToken($id)
    {
        $token = Hash::make(Str::random(10));
        DB::table('users_email_verify')->where('user_id', $id)->delete();
        DB::table('users_email_verify')->insert([
            'user_id' => $id,
            'token' => $token
        ]);
        return $token;
    }

    public function makeVerifyUrl($email, $id): string
    {
        return env('FRONTEND_URL') . '/verify-email?token=' . $this->initToken($id) . '&email=' . $email;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $url = $this->makeVerifyUrl($notifiable->email, $notifiable->id);
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
