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
        'password' => \Illuminate\Support\Facades\Hash::make("123456")
    ];
});

$factory->define(\App\Models\UserProfile::class, function (Faker $faker) {
    return [
        'user_id' => rand(1, 100),
        'phone' => $faker->phoneNumber,
    ];
});

$factory->define(\App\Models\Group::class, function (Faker $faker) {
    return [
        'name' => rand(0, 1000) . $faker->title,
        'type_id' => rand(1, 3),
        'organization_id' => rand(1, 3),
        'created_by' => rand(1, 3),
    ];
});

$factory->define(\App\Models\GroupType::class, function (Faker $faker) {
    return [
        'name' => rand(0, 1000) . $faker->title,
    ];
});


$factory->define(\App\Models\Organization::class, function (Faker $faker) {
    return [
        'name' => $faker->title . rand(0, 1000),
        'type_id' => 4,
        'parent_id' => rand(64, 614),
        'created_by' => rand(5, 100),
    ];
});
$factory->define(\App\Models\OrganizationType::class, function (Faker $faker) {
    return [
        'name' => rand(0, 1000) . $faker->title,
    ];
});
$factory->define(\App\Models\OrganizationProfile::class, function (Faker $faker) {
    return [
        'staff' => $faker->name,
        'email' => $faker->companyEmail,
        'phone' => $faker->phoneNumber,
        'gsm_phone' => $faker->phoneNumber,
        'address' => $faker->address,
    ];
});


