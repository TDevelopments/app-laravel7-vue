<?php

namespace Database\Factories;

use App\Models\ProductRange;
// use Illuminate\Database\Eloquent\Factories\Factory;

// class ProductRangeFactory extends Factory
// {
//     /**
//      * The name of the factory's corresponding model.
//      *
//      * @var string
//      */
//     protected $model = ProductRange::class;

//     /**
//      * Define the model's default state.
//      *
//      * @return array
//      */
//     public function definition()
//     {
//         return [
//             'model'         => $this->faker->bothify('??-####'),
//             'stock'         => $this->faker->randomNumber(3, true),
//             'brand'         => $this->faker->word(),
//             'catalogue_id'  => 1,
//             'category_id'   => rand(1, 4),
//         ];
//     }
// }
use Faker\Generator as Faker;

$factory->define(ProductRange::class, function (Faker $faker) {
    return [
        'model'         => $this->faker->bothify('??-####'),
        'stock'         => $this->faker->randomNumber(3, true),
        'brand'         => $this->faker->word(),
        'catalogue_id'  => 1,
        'category_id'   => rand(1, 4),
    ];
});
