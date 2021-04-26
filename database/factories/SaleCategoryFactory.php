<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SaleCategory;
use Faker\Generator as Faker;

$factory->define(SaleCategory::class, function (Faker $faker) {
    return [
        'CategoryName' => $this->faker->name(),
        'CategoryDescription' => $this->faker->sentence(),
        'Active' => $this->faker->randomElement([0, 1]),
    ];
});
