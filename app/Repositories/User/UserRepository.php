<?php

namespace App\Repositories\User;

use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface
{

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
}
