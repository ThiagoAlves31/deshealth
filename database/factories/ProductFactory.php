<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Product;
use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
		'name' 		=> $faker->unique->randomElement(['Dorflex 300gm', 'Xarelto','Selozok','Neosaldina',
											  'Torsilax','Aradois','Glifage XR','Addera D3','Anthelios',
											  'Buscopan','Losartana','Galvus','Benegripe']),

		'industry'  => $faker->randomElement(['Aché','Eurofarma','EMS','Bayer','Sanofi']),
		'price' 	=> $faker->randomNumber(2),
    ];
});
