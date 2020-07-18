<?php

use App\Models\Category;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(App\Models\Topic::class, function (Faker $faker) {

    $sentence = $faker->sentence();

    $updated_at = $faker->dateTimeThisMonth();

    $created_at = $faker->dateTimeThisMonth($updated_at);

    $user_id = User::inRandomOrder()->get()->first()->id;

    $category_id = Category::inRandomOrder()->get()->first()->id;

    return [
        'title' => $sentence,
        'body' => $faker->text(),
        'user_id' => empty($user_id) ? 1 : $user_id,
        'category_id' => $category_id,
        'excerpt' => $sentence,
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});
