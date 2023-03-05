<?php

namespace App\Repositories\User;

use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface
{

    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return User|Authenticatable|null
     */
    public function auth(): User|Authenticatable|null
    {
        return Auth::user();
    }

    /**
     * @return UserCollection
     */
    public function users(): UserCollection
    {
        return new UserCollection(User::where('id', '!=', auth()->id())->paginate(10));
    }


    public function changeEmail(): JsonResponse
    {
        $this->request->validate([
            'email' => 'required|unique:users|email',
        ]);

        $user = Auth::user();
        $user->email = $this->request->email;
        $user->save();
        return response()->json(['email' => $user->email],200);
    }

}
