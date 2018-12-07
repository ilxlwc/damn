<?php

use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {

    $client_ids = \App\Client::pluck('id')->toArray();

    return [
    	'client_id'=> $faker->randomElement($client_ids),
    	'apply_amount'=> $faker->numberBetween($min = 1000, $max = 9000),
    	'status'=> 1,
    	'service_type'=>$faker->lexify('service type ???????'),
    	'charge'=>$faker->numberBetween($min = 500 , $max = 1000),
    	'returnfee'=>$faker->numberBetween($min = 1 , $max = 499),
    	'name'=>$faker->name,
    	'age'=>$faker->numberBetween($min = 20, $max = 50),
    	'gender'=> $faker->numberBetween($min = 0, $max = 2),
    	'idcard'=> $faker->creditCardNumber,
    	'marital_status'=> $faker->numberBetween($min = 0, $max = 2),
    	'coborrower_relation'=> $faker->lexify('coborrower relation ???????'),
    	'coborrower_name'=>$faker->name,
    	'coborrower_gender'=> $faker->numberBetween($min = 0, $max = 2),
        'coborrower_idcard'=> $faker->creditCardNumber,
        'coborrower_Tel'=> $faker->phoneNumber,
        'credit_record'=> $faker->numberBetween($min = 0, $max = 1),
        'credit_record_status'=> $faker->numberBetween($min = 0, $max = 1),
        'overdue'=> $faker->numberBetween($min = 0, $max = 1),
        'house_type'=> $faker->lexify('house type ???????'), 
        'house_owner'=>$faker->name,
        'owner_type'=> $faker->numberBetween($min = 0, $max = 2),
        'house_address'=> $faker->address,
		'house_owner_certificate'=> $faker->lexify('house owner certificate ???????'), 
    ];
});
