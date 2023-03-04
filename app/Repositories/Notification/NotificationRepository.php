<?php

namespace App\Repositories\Notification;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class NotificationRepository implements NotificationRepositoryInterface
{

    /**
     * @return JsonResponse
     */
    public function getAllNotifications(): JsonResponse
    {
        $notifications = collect(Auth::user()->notifications)
            ->sortByDesc('created_at')
            ->map(function ($item) {
                $filterItem = $item->data;
                $filterItem['created'] = $item->created_at;
                $filterItem['readAt'] = $item->read_at;
                $filterItem['id'] = $item->id;
                return $filterItem;
            });
        return Response::json(['notifications' => $notifications, 'count' => $notifications->count()]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function markAsRead($id): JsonResponse
    {
        $userNotification = auth()->user()
            ->notifications
            ->find($id);
        if ($userNotification->read_at) {
            $userNotification->markAsUnread();
            return Response::json();
        }
        $userNotification->markAsRead();
        return Response::json();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $userNotification = auth()->user()
            ->notifications
            ->find($id);
        $userNotification->delete();
        return Response::json([], 204);
    }
}
