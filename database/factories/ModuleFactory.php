<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Module;
use Faker\Generator as Faker;

$factory->define(Module::class, function (Faker $faker) {

    return [
        'name'=>$faker->word(),
        'description'=>$faker->text(),
    ];
});
$factory->afterMaking(Module::class,function(Module $module){
    $module->save();
    for($s = 1 ; $s <= 2 ; $s++){
        $remain = 100 ;
        for($i = 1 ; $i <= 6 ; $i++){
            $rand = rand(0,$remain);
            if($rand < 20){
                $rand = $remain;
            }
            if($rand > 0){
                $dev  = factory(App\Devoir::class)->make(['module_id'=>$module->id,'ratio'=>$rand,'session'=>$s]);
                $dev->save();
            }
            $remain -= $rand;
        }
    }
});
