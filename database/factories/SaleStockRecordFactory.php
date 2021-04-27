<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SaleStockRecord;
use Faker\Generator as Faker;

$factory->define(SaleStockRecord::class, function (Faker $faker) {
    return [
        'sale_product_id' => function(){
    		    return App\Models\SaleProduct::all()->random();
    	    },
        'sale_product_status_id' => function(){
    		    return App\Models\SaleProductStatus::all()->random();
    	    },
        'sale_business_location_id' => function(){
    		    return App\Models\SaleBusinessLocation::all()->random();
    	    },
        'sale_customer_id' => function(){
    		    return App\Models\SaleCustomer::all()->random();
    	    },
        'Quantity' => $faker->randomNumber(2, false),

    ];
});
