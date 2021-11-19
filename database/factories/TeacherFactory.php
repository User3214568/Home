<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Teacher;
use App\User;
use Faker\Generator as Faker;

$factory->define(Teacher::class, function (Faker $faker) {
    $user = factory(User::class)->make(['type'=>1]);
    return [
        'user_cin'=>$user->cin
    ];
});
