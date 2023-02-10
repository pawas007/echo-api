<?php

namespace App\Http\Controllers;

use App\Notifications\PushNotifyNotification;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Models\User;

class FriendController extends Controller
{

    public ?Authenticatable $user;

    /**
     * @return JsonResponse
     */
    public function friend(): JsonResponse
    {

        return Response::json(Auth::user()->friends()->paginate(10));
    }

    /**
     * @return JsonResponse
     */
    public function friendPending(): JsonResponse
    {
        return Response::json(Auth::user()->friendPendingRequest()->paginate(10));
    }

    /**
     * @param User $user
     * @return JsonResponse
     */
    public function friendPendingCansel(User $user): JsonResponse
    {
        if (!Auth::user()->friendPendingRequest->contains($user)) {
            return Response::json(['message' => 'Friend request not found']);
        }
        Auth::user()->pendingCancel($user);
        return Response::json([], 204);
    }

    /**
     * @return JsonResponse
     */
    public function friendRequest(): JsonResponse
    {
        return Response::json(Auth::user()->friendRequest()->paginate(10));
    }

    /**
     * @return JsonResponse
     */
    public function friendAccept(User $user)
    {
        Auth::user()->friendAccept($user);
        $user->notify(new PushNotifyNotification(Auth::user(), 'accept', 'accept friend request'));
        return Response::json(['name' => $user->name]);
    }

    /**
     * @return JsonResponse
     */
    public function friendDecline(User $user)
    {
        Auth::user()->friendDecline($user);
        return Response::json(['name' => $user->name], 204);
    }


    /**
     * @param User $user
     * @return JsonResponse
     */
    public function friendAdd(User $user): JsonResponse
    {
        if (Auth::user()->friendPendingRequest->contains($user)) {
            return Response::json(['message' => 'Friend request already isset']);
        }
        if (Auth::user()->friends->contains($user)) {
            return Response::json(['message' => 'Friend request already added']);
        }
        Auth::user()->friendAdd($user);
        $user->notify(new PushNotifyNotification(Auth::user(), 'request', 'send friend request'));
        return Response::json([]);
    }


    /**
     * @param User $user
     * @return JsonResponse
     */
    public function friendDelete(User $user): JsonResponse
    {
        Auth::user()->friendDelete($user);
        return Response::json([], 204);
    }

    /**
     * @return JsonResponse
     */
    public function friendCounts(): JsonResponse
    {
        return Response::json(Auth::user()->friendCounts());
    }

}

//TODO : response only json
