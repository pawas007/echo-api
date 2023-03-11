<?php

namespace App\Repositories\Friend;

use App\Models\Friend;
use App\Models\User;
use App\Notifications\PushNotifyNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class FriendRepository implements FriendRepositoryInterface
{
    /**
     * @return JsonResponse
     */
    public function friendsList(): JsonResponse
    {
        $authUser = Auth::user();
        return Response::json($authUser->friends()->with('profile')->paginate(10));
    }

    /**
     * @return JsonResponse
     */
    public function friendPending(): JsonResponse
    {
        $authUser = Auth::user();
        return Response::json($authUser->friendPendingRequest()->with('profile')->paginate(10));
    }

    /**
     * @return JsonResponse
     */
    public function friendRequest(): JsonResponse
    {
        $authUser = Auth::user();
        return Response::json($authUser->friendRequest()->with('profile')->paginate(10));
    }

    /**
     * @param  User  $user
     * @return JsonResponse
     */
    public function friendAdd(User $user): JsonResponse
    {
        $authUser = Auth::user();
        if ($authUser->friendPendingRequest->contains($user)) {
            return Response::json(['message' => 'Friend request already isset']);
        }
        if ($authUser->friends->contains($user)) {
            return Response::json(['message' => 'You are friends']);
        }

        $authUser->friends()->attach(
            $authUser->id, [
                'friend_id' => $user->id,
                'status' => Friend::STATUS_PENDING
            ]
        );

        $user->notify(new PushNotifyNotification($authUser, 'request', 'send friend request'));
        return Response::json([]);
    }

    /**
     * @param  User  $user
     * @return JsonResponse
     */
    public function friendAccept(User $user): JsonResponse
    {
        try {
            $authUser = Auth::user();
            $friendSendRequest =
                Friend::where('user_id', $user->id)
                    ->where('status', Friend::STATUS_PENDING)
                    ->where('friend_id', $authUser->id)
                    ->first();
            DB::beginTransaction();
            if (!$friendSendRequest) {
                return Response::json(['message' => 'Friend send request not found'], 404);
            }
            $authUser->friendPendingRequest->contains($user) && $authUser->friendPendingRequest()->detach($user->id);

            $friendSendRequest->status = Friend::STATUS_ACCEPTED;
            $friendSendRequest->save();
            $authUser->friends()->attach(
                $authUser->id, [
                    'friend_id' => $user->id,
                    'status' => Friend::STATUS_ACCEPTED
                ]
            );
            DB::commit();
            $user->notify(new PushNotifyNotification($authUser, 'accept', 'accept friend request'));
            return Response::json();
        } catch (\Exception $exception) {
            DB::rollBack();
            return Response::json($exception->getMessage());
        }

    }


    /**
     * @param  User  $user
     * @return JsonResponse
     */
    public function friendPendingCansel(User $user): JsonResponse
    {
        $authUser = Auth::user();
        if (!$authUser->friendPendingRequest->contains($user)) {
            return Response::json(['message' => 'Friend request not found']);
        }

        $authUser->friendPendingRequest()->detach($user->id);
        return Response::json([], 204);
    }

    /**
     * @param  User  $user
     * @return JsonResponse
     */
    public function friendDecline(User $user): JsonResponse
    {
        $authUser = Auth::user();
        $authUser->friendRequest()->detach($user->id);
        return Response::json(['name' => $user->name], 204);
    }


    /**
     * @param  User  $user
     * @return JsonResponse
     */
    public function friendDelete(User $user): JsonResponse
    {
        $authUser = Auth::user();
        $authUser->friends()->detach($user->id);
        $user->friends()->detach($authUser->id);
        return Response::json([], 204);
    }

    /**
     * @return JsonResponse
     */
    public function counts(): JsonResponse
    {
        $authUser = Auth::user();
        return Response::json([
            'friends' => $authUser->friends()->count(),
            'pending' => $authUser->friendPendingRequest()->count(),
            'request' => $authUser->friendRequest()->count(),
        ]);
    }

}
