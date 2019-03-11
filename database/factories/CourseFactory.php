<?php

use Faker\Generator as Faker;

$factory->define(App\Course::class, function (Faker $faker) {
    return [
        //
		'name' => $faker->company,
		'course_type' => $faker->numberBetween(1,2),
		'schedule' => $faker->sentence(3),
		'max_team_size' => $faker->numberBetween(1,20),
		'course_key' => $faker->swiftBicNumber,
    ];
});
