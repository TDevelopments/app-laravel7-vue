<?php

namespace Database\Factories;

use App\Models\Catalogue;
// use Illuminate\Database\Eloquent\Factories\Factory;

// class CatalogueFactory extends Factory
// {
//     /**
//      * The name of the factory's corresponding model.
//      *
//      * @var string
//      */
//     protected $model = Catalogue::class;

//     /**
//      * Define the model's default state.
//      *
//      * @return array
//      */
//     public function definition()
//     {
//         return [
//             'name'                  => $this->faker->name(),
//             'quota_price'           => 200,
//             'quota_date'            => $this->faker->dateTime(),
//             'minimum_investment'    => 2000,
//             'first_payment'         => 0.4,
//             'date_first_payment'    => $this->faker->dateTime(),
//             'second_payment'        => 0.6,
//             'date_second_payment'   => $this->faker->dateTime(),
//         ];
//     }
// }
use Faker\Generator as Faker;

$factory->define(Catalogue::class, function (Faker $faker) {
    return [
        'name'                  => $this->faker->name(),
        'conditions'            => $this->faker->sentences(),
        'coin'                  => $this->faker->randomElement(['soles', 'dolares']),
        'is_available'          => 1,
        'quota_price'           => 200,
        'quota_date'            => $this->faker->dateTime(),
        'minimum_investment'    => 2000,
        'first_payment'         => 0.4,
        'date_first_payment'    => $this->faker->dateTime(),
        'second_payment'        => 0.6,
        'date_second_payment'   => $this->faker->dateTime(),
    ];
});
