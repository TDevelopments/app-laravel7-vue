<?php

namespace Database\Factories;

use App\Models\Product;
// use Illuminate\Database\Eloquent\Factories\Factory;

// class ProductFactory extends Factory
// {
//     /**
//      * The name of the factory's corresponding model.
//      *
//      * @var string
//      */
//     protected $model = Product::class;

//     /**
//      * Define the model's default state.
//      *
//      * @return array
//      */
//     public function definition()
//     {
//         return [
//             'description'   => $this->faker->sentences(),
//             'model'         => $this->faker->bothify('??-####'),
//             'stock'         => $this->faker->randomNumber(3, true),
//             'brand'         => $this->faker->word(),
//             'price_unit'    => $this->faker->randomFloat(2, 10, 100),
//             'price_group'   => $this->faker->randomFloat(2, 100, 1000),
//             'quantity_group'=> $this->faker->numberBetween(10, 20),
//             'type_group'    => $this->faker->randomElement(['units', 'sets']),
//             'catalogue_id'  => 1,
//             'category_id'   => rand(1, 4),
//         ];
//     }
// }
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'description'   => $this->faker->sentences(),
        'sku'           => $this->faker->bothify('SKU-??####'),
        'model'         => $this->faker->bothify('??-####'),
        'stock'         => $this->faker->randomNumber(3, true),
        'brand'         => $this->faker->word(),
        'price_unit'    => $this->faker->randomFloat(2, 10, 100),
        'price_group'   => $this->faker->randomFloat(2, 100, 1000),
        'quantity_group'=> $this->faker->numberBetween(10, 20),
        'type_group'    => $this->faker->randomElement(['units', 'sets']),
        'catalogue_id'  => $this->faker->numberBetween(1, 2),
        'category_id'   => rand(1, 4),
    ];
});
