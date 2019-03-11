<?php

use Faker\Generator as Faker;

$factory->define(App\Tag::class, function (Faker $faker) {
    return [
		'name' => $faker->jobTitle,
		'type' => $faker->numberBetween(1,2)
    ];
});
