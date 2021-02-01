<?php

declare(strict_types=1);

namespace App\Repositories\Commands;

use App\Models\ProvaResultado;
use App\Repositories\Queries\ProvaCorredorQueryRepository;
use Illuminate\Http\Request;

class ProvaResultadoCommandRepository
{
    private $provaCorredorQuery;

    public function __construct(ProvaCorredorQueryRepository $provaCorredorQuery)
    {
        $this->provaCorredorQuery = $provaCorredorQuery;
    }

    public function create(array $request): ProvaResultado
    {
        $provaResultado = new ProvaResultado();

        $provaResultado->id_prova_corredor  = $request['id_prova_corredor'];
        $provaResultado->inicio             = $request['inicio'];
        $provaResultado->fim                = $request['fim'];

        $provaResultado->save();

        return $provaResultado;
    }
}
