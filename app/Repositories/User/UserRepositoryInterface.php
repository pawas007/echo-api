<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{

    public function auth();

    public function users();

    public function updateEmail();

    public function updatePassword();

    public function updateProfile();

    public function updateAvatar();
    
    public function updatePoster();


}
