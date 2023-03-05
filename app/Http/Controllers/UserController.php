<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Http\Resources\UserCollection;
use Illuminate\Http\Request;

class UserController extends Controller
{

    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return Authenticatable|User
     */
    public function auth()
    {
        return $this->userRepository->auth();
    }

    /**
     * @return UserCollection
     */
    public function users()
    {
        return $this->userRepository->users();
    }

    /**
     * @return Request
     */
    public function changeEmail(Request $request)
    {
        return $this->userRepository->changeEmail($request);
    }

}
