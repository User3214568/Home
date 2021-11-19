<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Critere;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Critere::class, function (Faker $faker) {
    return [
        'note_validation'=> rand(10,12) ,
        'note_aj'=> rand(7,10) ,
        'number_aj'=> $faker->numberBetween(0,1),
        'number_nv'=> $faker->numberBetween(0,2),
    ];
});
$factory->afterMaking(Critere::class,function(Critere $critere){
    $critere->save();
});
