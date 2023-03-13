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
                    'country' => $faker->country,
                    'age' => rand(10, 109),
                    'sex' => 'Male',
                    'avatar' => null,
                    'poster' => null,
                    'address' => $faker->address,
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
