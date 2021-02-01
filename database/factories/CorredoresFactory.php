<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Models\Corredor;
use Carbon\Carbon;

$factory->define(Corredor::class, function (Faker $faker) {
    return [
        'nome' => $faker->name,
        'cpf'  => '034.415.010-04',
        'data_nascimento' => Carbon::now()->subYears(rand(18, 99))
    ];
});
