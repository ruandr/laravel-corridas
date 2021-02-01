<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ProvaResultado;
use App\Services\ProvaResultadoService;
use App\Repositories\Queries\ProvaCorredorQueryRepository;
use Faker\Generator as Faker;

$factory->define(ProvaResultado::class, function (Faker $faker) {
    $service = resolve(ProvaResultadoService::class);
    $provaCorredorQueries = resolve(ProvaCorredorQueryRepository::class);

    $pendingIds = $service->getPendingResults();
    $keyId = array_rand($pendingIds);
    $id = $pendingIds[$keyId];

    $validHours = $service->getRandValidHours();

    $provaCorredor = $provaCorredorQueries->getByIdResumed($id);
    if (sizeof($pendingIds) > 0 && !is_null($provaCorredor)) {
        $data = $provaCorredor->data;
        return [
            'id_prova_corredor' => $id,
            'inicio'            => $data . ' ' . $validHours['start'] . ':00',
            'fim'               => $data . ' ' . $validHours['end'] . ':00'
        ];
    } else {
        return [];
    }
});
