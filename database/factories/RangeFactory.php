<?php

namespace Database\Factories;

use App\Models\Range;
// use Illuminate\Database\Eloquent\Factories\Factory;

// class RangeFactory extends Factory
// {
//     /**
//      * The name of the factory's corresponding model.
//      *
//      * @var string
//      */
//     protected $model = Range::class;

//     /**
//      * Define the model's default state.
//      *
//      * @return array
//      */
//     public function definition()
//     {
//         return [
//             'min'   => $this->faker->numberBetween(0, 10),
//             'max'   => $this->faker->numberBetween(10, 20), 
//             'price' => $this->faker->randomFloat(2, 200, 350),
//             'product_range_id' => rand(1, 20)
//         ];
//     }
// }
use Faker\Generator as Faker;

$factory->define(Range::class, function (Faker $faker) {
    return [
        'min'   => $this->faker->numberBetween(0, 10),
        'max'   => $this->faker->numberBetween(10, 20), 
        'price' => $this->faker->randomFloat(2, 200, 350),
        'product_range_id' => rand(1, 20)
    ];
});
