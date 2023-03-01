<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function auth()
    {
        return Response::json(Auth::user());

    }

    /**
     * @return UserCollection
     */
    public function users()
    {
        return new UserCollection(User::where('id', '!=', auth()->id())->paginate(10));
    }

}
