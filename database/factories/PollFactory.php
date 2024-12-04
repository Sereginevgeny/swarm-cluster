<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model\Poll::class, function (Faker $faker) {
    return [
        'question' => $faker->sentence(5, true),
    ];
});
