<?php

namespace App\Http\Controllers;

use App\Repositories\Notification\NotificationRepositoryInterface;
use Illuminate\Http\JsonResponse;

class NotificationsController extends Controller
{

    protected NotificationRepositoryInterface $notificationRepository;

    /**
     * @param NotificationRepositoryInterface $notificationRepository
     */
    public function __construct(NotificationRepositoryInterface $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->notificationRepository->getAllNotifications();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function markAsRead($id): JsonResponse
    {
        return $this->notificationRepository->markAsRead($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        return $this->notificationRepository->destroy($id);
    }
}
