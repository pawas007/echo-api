<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use App\Models\UserSetting;
use Faker\Factory;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    public function run()
    {
        $faker = Factory::create();
        User::factory(60)->create()->each(function ($user) use ($faker) {
            Profile::create(
                [
                    'user_id' => $user['id'],
                    'sex' => 'Male',
                    'avatar' => null,
                    'poster' => null,
                    'country' => $faker->country,
                    'region' => $faker->city,
                    'city' => $faker->city,
                    'locality' => $faker->city,
                    'about' => $faker->text(200),
                    'quote' => $faker->text(30),
                    'birthday' => $faker->dateTime
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
