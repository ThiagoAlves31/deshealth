<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Stock;

$factory->define(Stock::class, function (Faker $faker) {
    return [
        'product_id' => function () {
            return factory(App\Product::class)->create()->id;
        },
        'amount' 	 => rand(5,10)
    ];
});
