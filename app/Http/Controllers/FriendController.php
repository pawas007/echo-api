<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\Friend\FriendRepositoryInterface;

class FriendController extends Controller
{

    /**
     * @var FriendRepositoryInterface
     */
    protected FriendRepositoryInterface $friendRepository;

    /**
     * @param FriendRepositoryInterface $friendRepository
     */
    public function __construct(FriendRepositoryInterface $friendRepository)
    {
        $this->friendRepository = $friendRepository;
    }

    /**
     * @return mixed
     */
    public function friend()
    {
        return $this->friendRepository->friendsList();
    }

    /**
     * @return mixed
     */
    public function friendPending()
    {
        return $this->friendRepository->friendPending();
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function friendPendingCansel(User $user)
    {
        return $this->friendRepository->friendPendingCansel($user);
    }

    /**
     * @return mixed
     */
    public function friendRequest()
    {
        return $this->friendRepository->friendRequest();
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function friendAccept(User $user)
    {
        return $this->friendRepository->friendAccept($user);
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function friendDecline(User $user)
    {
        return $this->friendRepository->friendDecline($user);
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function friendAdd(User $user)
    {
        return $this->friendRepository->friendAdd($user);
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function friendDelete(User $user)
    {
        return $this->friendRepository->friendDelete($user);
    }

    /**
     * @return void
     */
    public function friendCounts()
    {
        return $this->friendRepository->counts();
    }
}

