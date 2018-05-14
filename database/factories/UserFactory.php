<?php

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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('secret123'),
        'remember_token' => str_random(10),
    ];
});
$factory->define(\App\Models\Blog\Article::class, function (Faker $faker) {
    return [
        'author_id' => factory(\App\User::class)->create()->id,
        'title' => $faker->sentence,
        'content' => $faker->randomHtml(8,8),
    ];
});
