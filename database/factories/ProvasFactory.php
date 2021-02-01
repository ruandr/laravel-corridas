<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Prova;
use Faker\Generator as Faker;
use App\Enums\TipoProvasEnum;
use Carbon\Carbon;

$factory->define(Prova::class, function (Faker $faker) {
    $item = array_rand(TipoProvasEnum::toArray());

    return [
        'tipo_prova' => TipoProvasEnum::toArray()[$item],
        'data' => Carbon::now()->addDays(rand(1, 60))
    ];
});

