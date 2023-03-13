<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserSetting;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SingleUserSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        $user = User::create([
            'name' => 'Arnold',
            'email' => 'arnold@example.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'phone' => substr($faker->e164PhoneNumber, 1),
        ]);
        $user->profile()->create([
            'country' => $faker->country,
            'age' => rand(10, 109),
            'poster' => null,
            'address' => $faker->address,
            'sex' => 'Male',
            'about' => $faker->text(20),
            'quote' => $faker->text(5),
            'birthday' => $faker->dateTime
        ]);
        UserSetting::create([
            'user_id' => $user->id,
            'notifications' => [
                'email' => true,
                'sound' => true,
                'push' => true,
            ]
        ]);
    }
}
