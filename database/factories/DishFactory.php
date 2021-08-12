<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Dish;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(Dish::class, function (Faker $faker) {
    $faker = \Faker\Factory::create();
    $faker->addProvider(new \FakerRestaurant\Provider\it_IT\Restaurant($faker));
    
    $usersIDs = DB::table('users')->pluck('id'); 
    $users = $usersIDs->toArray();
            $randPickUserId = $users[rand(0, count($users) - 1)];

    return [
        'name' => $faker->foodName(),
        'user_id' => $randPickUserId,
        'ingredients' => $faker->dairyName().", "
                                .$faker->vegetableName().", "
                                .$faker->meatName().", "
                                .$faker->sauceName(),
        'description' => $faker->text(),
        'price' => $faker->randomFloat(2, 0, 20),
        'visibility' => true
    ];
});
