<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SaleOrder;
use Faker\Generator as Faker;

$factory->define(SaleOrder::class, function (Faker $faker) {
    return [
        'OrderDate' => $this->faker->date(),
        'ShipDate' => $this->faker->date(),
        'SalesTax' => $this->faker->randomFloat(2, 10, 100),
        'Delete' => $this->faker->randomElement([0, 1]),
        'customer_id' => rand(1, 20),
        'sale_state_id' => rand(1, 3),
    ];
});
