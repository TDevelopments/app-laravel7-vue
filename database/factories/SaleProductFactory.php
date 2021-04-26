<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SaleProduct;
use App\Models\SalePicture;
use Faker\Generator as Faker;

$factory->define(SaleProduct::class, function (Faker $faker) {
    return [
        'Sku' => $this->faker->regexify('[A-Z]{5}[0-4]{3}'),
        'ProductName' => $this->faker->name(),
        'ProductDescription' => $this->faker->sentence(),
        'QuantityPerUnit' => $this->faker->randomElement([0, 1]),
        'UnitPrice' => $this->faker->randomFloat(2, 10, 100),
        'SellingPrice' => $this->faker->randomFloat(2, 10, 100),
        'AvailableSize' => $this->faker->randomElement([0, 1]),
        'AvailableColors' => $this->faker->randomElement([0, 1]),
        'AvailableGender' => $this->faker->randomElement([0, 1]),
        'Size' => array($this->faker->randomNumber(2, true)),
        'Color' => array($this->faker->safeHexColor()),
        'Discount' => $this->faker->randomFloat(2, 10, 30),
        'UnitWeight' => $this->faker->randomFloat(2, 10, 30),
        'UnitsOnOrder' => $this->faker->randomNumber(2, false),
        'ProductAvailable' => $this->faker->randomElement([0, 1]),
        'DiscountAvailable' => $this->faker->randomElement([0, 1]),
        'sale_category_id' => function(){
    		    return App\Models\SaleCategory::all()->random();
    	    },
        'sale_brand_id' => function(){
    		    return App\Models\SaleBrand::all()->random();
    	    },
        'sale_product_unit_id' => function(){
    		    return App\Models\SaleProductUnit::all()->random();
    	    },
        'sale_product_type_id' => function(){
    		    return App\Models\SaleProductType::all()->random();
    	    },
    ];
});
