<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */



    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }


    /**
     * Handle a login request to the application.
     *
     * @param Request $request
     * @return JsonResponse
     *
     * @throws ValidationException
     */


    public function login(Request $request)
    {
        try {
            if (!Auth::attempt($request->only('email', 'password'))) {

                return Response::json(['message' => 'Invalid email or password'], 401);

            }
            $user = User::where('email', $request['email'])->firstOrFail();
            return Response::json([
                'status' => true,
                'token' => $user->createToken('auth_token')->plainTextToken,
            ], 200);

        } catch (Exception $e) {
            return Response::json($e->getMessage(), 500);
        }
    }
}
