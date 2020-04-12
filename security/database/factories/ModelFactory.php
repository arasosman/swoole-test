<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => \Illuminate\Support\Facades\Hash::make("456789")
    ];


});
$factory->define(\App\Models\UserProfile::class, function (Faker $faker) {
    return [
        'user_id' => rand(1, 100),
        'phone' => $faker->phoneNumber,
    ];
});
