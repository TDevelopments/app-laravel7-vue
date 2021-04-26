<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SalePicture;
use Faker\Generator as Faker;

$factory->define(SalePicture::class, function (Faker $faker) {
    return [
        'PictureName' => $faker->word(),
        'PicturePath' => $faker->image(public_path().'/uploads/salesModule/',640,480, null, false),
    ];
});
