<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Payment;
use Faker\Generator as Faker;

$factory->define(Payment::class, function (Faker $faker) {
    return [
        'value'     => (string) $faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = 99999999),
        'recipient' => $faker->company,
        'notificationURL' => $faker->url,
    ];
});
