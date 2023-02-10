<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function auth(): JsonResponse
    {
        return Response::json(Auth::user());

    }

    /**
     * @return JsonResponse
     */
    public function users(): JsonResponse
    {
        $users = User::where('id', '!=', auth()->id())->paginate(10);
        return Response::json($users);
    }

}
