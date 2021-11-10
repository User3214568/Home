<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Critere;
use App\Formation;
use Faker\Generator as Faker;

$factory->define(Formation::class, function (Faker $faker) {
    $critere = factory(Critere::class)->make();
    return [
        'name'=>$faker->word(),
        'description'=>$faker->text(),
        'prix'=>$faker->randomNumber(5),
        'critere_id'=>$critere->id,
    ];
});

