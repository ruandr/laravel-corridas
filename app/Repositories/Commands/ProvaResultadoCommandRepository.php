<?php

declare(strict_types=1);

namespace App\Respositories\Commands;

use App\Models\ProvaResultado;
use App\Repositories\Queries\ProvaCorredorQueryRepository;

class ProvaResultadoCommandRepository
{
    private $provaCorredorQuery;

    public function __construct(ProvaCorredorQueryRepository $provaCorredorQuery)
    {
        $this->provaCorredorQuery = $provaCorredorQuery;
    }

    public function create(request $request): ProvaResultado
    {
        $provaCorredor = $provaCorredorQuery->getByExternalIds($request->get('proof_id'), $request->get('runner_id'));

        $provaResultado = new ProvaResultado;

        $provaResultado->id_prova_corredor  = $provaCorredor->id;
        $provaResultado->inicio             = $request->get('start');
        $provaResultado->fim                = $request->get('end');

        $provaResultado->save();
    }
    public function delete(int $id): void
    {
        $provaResultado = ProvaResultado::find($id);
        $provaResultado->delete();
    }
}
