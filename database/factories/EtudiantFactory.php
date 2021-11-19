<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Etudiant;
use Faker\Generator as Faker;

$factory->define(Etudiant::class, function (Faker $faker,$infos) {
    $user = factory(App\User::class)->make(['type'=>1]);
    return [
        'user_cin'=>$user->cin,
        'born_place'=>$infos['born_place'],
        'born_date'=>$infos['born_date'],
        'promotion_id' => $infos['promotion_id']
    ];
});
