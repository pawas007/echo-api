<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Http\Requests\CreateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
    /**
     * @param CreateUserRequest $request
     * @return JsonResponse
     */
    public function register(CreateUserRequest $request): JsonResponse
    {


        $validator = Validator::make($request->all(),
            [
                'email' => 'required|unique:users',
            ]
        );

        if ($validator->fails()) {
            return Response::json($validator->errors(), 422);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => Carbon::now(),
        ]);

        return Response::json(['status' => 'success']);
    }
}
