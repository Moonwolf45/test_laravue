<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Sections;
use Faker\Generator as Faker;

$factory->define(Sections::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(8),
        'description' => $faker->realText(200),
        'logo' => '/' . $faker->image('images',300,300)
    ];
});
