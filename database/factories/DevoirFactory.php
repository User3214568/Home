<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Devoir;
use Faker\Generator as Faker;

$factory->define(Devoir::class, function (Faker $faker,$infos) {
    return [
        'name'=>$faker->word(),
        'ratio'=>$infos['ratio'],
        'session'=>$infos['session'],
        'module_id'=> $infos['module_id'],
    ];
});
