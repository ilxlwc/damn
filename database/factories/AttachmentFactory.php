<?php

use Faker\Generator as Faker;

$factory->define(App\Attachment::class, function (Faker $faker) {

    $order_ids = \App\Order::pluck('id')->toArray();

    return [
        'order_id'=> $faker->randomElement($order_ids),
    	//'url'=> $faker->image($dir = public_path().'/tmp', $width = 640, $height = 480),
    	'url'=> $faker->imageUrl($width = 640, $height = 480),
        'file_type'=> $faker->numberBetween($min = 0, $max = 7),    	
    ];
});
