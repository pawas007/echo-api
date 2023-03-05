<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{

    public function auth();

    public function users();

    public function changeEmail();


}
