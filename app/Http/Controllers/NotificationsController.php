<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class NotificationsController extends Controller
{
    public function index(): JsonResponse
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

    public function destroy($id)
    {
        $userNotification = auth()->user()
            ->notifications
            ->find($id);
        $userNotification->delete();
        return Response::json([], 204);
    }
}
