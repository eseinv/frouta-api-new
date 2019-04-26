<?php

function bcrypt($value, $options = []){
return app('hash')->make($value, $options);
}

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->email,
        'password' => bcrypt('test'),
        'type' => 'admin'
    ];
});