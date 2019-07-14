<?php

use App\User;
use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'name'    =>$faker->word,
        'description' => $faker->paragraph(1),
        'quantity'  => $faker->numberBetween(1, 10),
        'available' => $faker->randomElement([true, false]),
        'image'     => $faker->randomElement(['1.PNG', '2.jpg', '3.jpg']),
        
    ];
});
