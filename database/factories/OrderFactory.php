<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'customer_name' => $faker->name(),
        'customer_phone_number' => $faker->phoneNumber(),
        'delivery_address' => $faker->address(),
        'customer_mail' => $faker->safeEmail,
        'payment_amount' => $faker->randomFloat(2, 0, 99),
        'payment_status' => true,
        'created_at' => $faker->dateTimeBetween($startDate = '01-01-2020', $endDate = 'now')->format('d-m-Y H:i:s'),
        'updated_at' => now()
    ];
});
