<?php

use Faker\Generator as Faker;

$factory->defineAs(App\Saude::class,'eins', function (Faker $faker) {


    return [

		'datum' => $faker->dateTimeBetween($startDate = '-2 weeks', $endDate = 'now')->format('Y-m-d'),
		'uhrzeit' => $faker->time($format = 'H:i:s', $max = 'now'),
		'gewicht' => $faker->randomFloat($nbMaxDecimals = 1, $min = 60, $max = 130),
		'diastole' => $faker->numberBetween($min = 60, $max = 110),
		'systole'  => $faker->numberBetween($min = 110, $max = 200),
		'puls' => $faker->numberBetween($min = 60, $max = 200),
		'description' => $faker->text(200),
		'uuid' => $faker->uuid,
		'user_id' => $faker->randomDigit,
	];
	
});
