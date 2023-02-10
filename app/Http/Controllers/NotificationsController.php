<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class NotificationsController extends Controller
{
    public function index()
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

    public function markAsRead()
    {

    }


    public function destroy(Notification $notification)
    {
    }
}
