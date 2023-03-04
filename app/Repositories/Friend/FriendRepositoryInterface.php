<?php

namespace App\Repositories\Friend;


use App\Models\User;


interface FriendRepositoryInterface
{

    public function friendsList();

    public function friendPending();

    public function friendPendingCansel(User $user);

    public function friendRequest();

    public function friendAccept(User $user);

    public function friendDecline(User $user);

    public function friendAdd(User $user);

    public function friendDelete(User $user);

    public function counts();

}
