<?php

namespace App\Listeners;

use App\Events\UserRegisterEvent;

class CreateUserProfileListener
{
    public function __construct()
    {
    }

    public function handle(UserRegisterEvent $event)
    {
        $event->user->profile()->create();
        $event->user->sendVerificationEmail();
    }
}
