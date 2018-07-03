<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'content' => $faker->sentence,
        'image' => 'photo1.png',
        'date' => '07/03/18',
        'views' => $faker->numberBetween(0, 10000),
        'category_id' => 1,
        'user_id' => 1,
        'status' => 1,
        'is_featured' => 0,
    ];
});
