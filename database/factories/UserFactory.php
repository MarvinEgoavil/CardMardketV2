<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Models\Sale;
use App\Models\Collection;
use App\Models\Game_card;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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
        'name' => $faker->unique()->name,
        'email' => $faker->unique()->safeEmail,
        //'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        // 'remember_token' => Str::random(10),
        'role' => $faker->randomElement($array = array('admin', 'profe', 'parti')),
    ];
});

$factory->define(Sale::class, function (Faker $faker) {
    return [
        'quantity' => $faker->numberBetween($min = 1, $max = 20),
        'price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 10, $max = 50000),
        'game_card_id' => $faker->numberBetween($min = 1, $max = 60),
    ];
});

$factory->define(Collection::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'symbol' => $faker->imageUrl($width = 640, $height = 480),
        'edition_date' => $faker->dateTimeInInterval($startDate = 'now', $interval = '+ 60 days', $timezone = null),
    ];
});

$factory->define(Game_card::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text($maxNbChars = 80),
        'user_id' => $faker->numberBetween($min = 1, $max = 30),

    ];
});
