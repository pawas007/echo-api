<?php

namespace App\Http\Controllers;


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
    public function friendAdd(User $user): JsonResponse
    {
        if (Auth::user()->friendPendingRequest->contains($user)) {
            return Response::json(['message' => 'Friend request already isset']);
        }
        Auth::user()->friendAdd($user);
        return Response::json(['name' => $user->name], 203);
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
     * @param User $user
     * @return JsonResponse
     */
    public function friendDelete(User $user): JsonResponse
    {
        Auth::user()->friendDelete($user);
        return Response::json([], 204);
    }


}
