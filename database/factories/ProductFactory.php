<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Product;
use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
		'name' 		=> $faker->name,
		//'name' 		=> (rand(0,1) == true) ? 'Dipirona' : 'Losartana',
		'industry'  => (rand(0,1) == true) ? 'Medley' : 'Aché',
		'price' 	=> $faker->randomNumber(2),
    ];
});
