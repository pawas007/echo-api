<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory(60)->create()->each(function ($user) {
            Profile::create(
                [
                    'user_id' => $user['id'],
                    'country' => null,
                    'age' => Profile::age[array_rand(Profile::age)],
                    'sex' => null,
                    'avatar' => null,
                ]
            );
            UserSetting::create([
                'user_id' => $user['id'],
                    'notifications' => [
                        'email' => true,
                        'sound' => true,
                        'push' => true,
                    ]

            ]);
        });
    }
}
