<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;

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
     * @return JsonResponse
     */
    public function updateEmail()
    {
        return $this->userRepository->updateEmail();
    }

    /**
     * @return JsonResponse
     */
    public function updatePassword()
    {
        return $this->userRepository->updatePassword();
    }

    /**
     * @return JsonResponse
     * @throws Exception
     */
    public function updateProfile()
    {
        return $this->userRepository->updateProfile();
    }

    /**
     * @return JsonResponse
     */
    public function updateAvatar()
    {
        return $this->userRepository->updateAvatar();
    }

    /**
     * @return JsonResponse
     */
    public function updatePoster()
    {
        return $this->userRepository->updatePoster();
    }

}
