<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SaleCustomer;
use Faker\Generator as Faker;

$factory->define(SaleCustomer::class, function (Faker $faker) {
    return [
        'FirstName' => $this->faker->firstName(),
        'LastName' => $this->faker->lastname(),
        'Address1' => $this->faker->streetAddress(),
        'Address2' => $this->faker->streetAddress(),
        'City' => $this->faker->city(),
        'State' => $this->faker->state(),
        'PostalCode' => $this->faker->postcode(),
        'Country' => $this->faker->country(),
        'Phone' => $this->faker->phoneNumber(),
        'Email' => $this->faker->email(),
        'ShipAddress' => $this->faker->streetAddress(),
        'ShipCity' => $this->faker->city(),
        'ShipRegion' => $this->faker->citySuffix(),
        'ShipPostalCode' => $this->faker->postcode(),
        'ShipCountry' => $this->faker->country(),
        'BillingAddress' => $this->faker->streetAddress(),
        'BillingCity' => $this->faker->city(),
        'BillingRegion' => $this->faker->citySuffix(),
        'BillingPostalCode' => $this->faker->postcode(),
        'BillingCountry' => $this->faker->country(),
        'user_id' => function() {
            return factory(\App\Models\User::class)->create()->id;
        },
    ];
});
