<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->safeEmail,
        'password'       => str_random(10),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Model\News::class, function (Faker\Generator $faker) {
    return [
        'title'     => $faker->unique()->sentence(4),
        'date'      => $faker->dateTimeThisCentury,
        'published' => $faker->boolean(),
        'text'      => $faker->paragraph(5),
    ];
});

$factory->define(App\Model\Page::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->sentence(5),
        'text'  => $faker->paragraph(5),
    ];
});