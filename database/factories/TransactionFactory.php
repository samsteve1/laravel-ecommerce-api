<?php

use App\User;
Use App\Seller;
use Faker\Generator as Faker;

$factory->define(App\Transaction::class, function (Faker $faker) {

    $seller = User::has('products')->get()->random();
    // $buyer = User::all()->except($seller->id)->get()->random();
    return [
        'quantity'  =>  $faker->numberBetween(1, 3),
        'user_id'   => $faker->numberBetween(101, 200),
        'product_id' => $seller->products->random()->id,
    ];
});
