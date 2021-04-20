<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SaleProduct;
use Faker\Generator as Faker;

$factory->define(SaleProduct::class, function (Faker $faker) {
    return [
        'Sku' => $this->faker->regexify('[A-Z]{5}[0-4]{3}'),
        'ProductName' => $this->faker->name(),
        'ProductDescription' => $this->faker->sentece(),
        'QuantityPerUnit' => $this->faker->randomElement([0, 1]),
        'UnitPrice' => $this->faker->randomFloat(2, 10, 100),
        'AvailableSize' => $this->faker->randomElement([0, 1]),
        'AvailableColors' => $this->faker->randomElement([0, 1]),
        'Size' => $this->faker->randomNumber(2, true),
        'Color' => $this->faker->safeHexColor(),
        'Discount' => $this->faker->randomFloat(2, 10, 30),
        'UnitWeight' => $this->faker->randomFloat(2, 10, 30),
        'UnitMetric' => $this->faker->randomFloat(2, 10, 30),
        'UnitsOnOrder' => $this->faker->randomNumber(2, false),
        'UnitsOnStock' => $this->faker->randomNumber(2, false),
        'ProductAvailable' => $this->faker->randomElement([0, 1]),
        'DiscountAvailable' => $this->faker->randomElement([0, 1]),
        'Ranking' => $this->faker->numberBetween(0, 5),
        'category_id'   => rand(1, 4),
    ];
});
