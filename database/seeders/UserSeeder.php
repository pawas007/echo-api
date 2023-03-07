<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory(60)->create()->each(function ($user) {
            Profile::create(
                [
                    'user_id' => $user['id'],
                    'country' => 'Poland',
                    'age' => Profile::age[array_rand(Profile::age)],
                    'sex' => 'Male',
                    'avatar' => null,
                    'avatar_file' => null,
                ]
            );
        });
    }
}