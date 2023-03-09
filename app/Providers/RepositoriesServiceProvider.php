<?php

namespace App\Providers;

use App\Repositories\Friend\FriendRepository;
use App\Repositories\Friend\FriendRepositoryInterface;
use App\Repositories\Notification\NotificationRepository;
use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\SmsNotificator\SmsNotificatorInterface;
use App\Services\SmsNotificator\TwilioSender;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->bind(
            NotificationRepositoryInterface::class,
            NotificationRepository::class
        );
        $this->app->bind(
            FriendRepositoryInterface::class,
            FriendRepository::class
        );

        $this->app->bind(
            SmsNotificatorInterface::class,
            TwilioSender::class
        );
    }

    public function boot()
    {
    }
}
