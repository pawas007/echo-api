<?php

namespace App\Listeners;

use App\Events\UserRegisterEvent;
use App\Models\UserSetting;

class CreateUserProfileListener
{
    public function __construct()
    {
    }

    public function handle(UserRegisterEvent $event)
    {
        $event->user->profile()->create();
        $event->user->sendVerificationEmail();
        UserSetting::create([
            'user_id' => $event->user->id, 'notifications' => [
                'email' => true,
                'sound' => true,
                'push' => true,
            ]
        ]);
    }
}
