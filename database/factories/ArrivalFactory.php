<?php

namespace Database\Factories;

use App\Models\Arrival;
// use Illuminate\Database\Eloquent\Factories\Factory;

// class ArrivalFactory extends Factory
// {
//     /**
//      * The name of the factory's corresponding model.
//      *
//      * @var string
//      */
//     protected $model = Arrival::class;

//     /**
//      * Define the model's default state.
//      *
//      * @return array
//      */

//     public function definition()
//     {
//         return [
//             'city'          => $this->faker->word(),
//             'arrival_date'  => $this->faker->dateTime(),
//             'catalogue_id'  => 1,
//         ];
//     }
// }
use Faker\Generator as Faker;

$factory->define(Arrival::class, function (Faker $faker) {
    return [
        'city'          => $this->faker->word(),
        'arrival_date'  => $this->faker->dateTime(),
        'catalogue_id'  => 1,
    ];
});
