<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ProvaCorredor;
use App\Models\Prova;
use App\Models\Corredor;
use App\Services\ProvaCorredorService;
use Faker\Generator as Faker;

$factory->define(ProvaCorredor::class, function (Faker $faker) {
    $service = resolve(ProvaCorredorService::class);

    $ids = $service->getValidsRandomExternalIds();

    if ($ids['idProva'] != 0 && $ids['idCorredor'] != 0) {

         return [
            'id_prova' => $ids['idProva'],
            'id_corredor' => $ids['idCorredor']
        ];
    }
});
