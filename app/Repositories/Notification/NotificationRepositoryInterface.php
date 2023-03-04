<?php

namespace App\Repositories\Notification;

interface NotificationRepositoryInterface
{

    public function getAllNotifications();

    public function markAsRead($id);

    public function destroy($id);
}
