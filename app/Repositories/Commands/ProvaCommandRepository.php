<?php

declare(strict_types=1);

namespace App\Repositories\Commands;

use App\Models\Prova;
use Illuminate\Http\Request;

class ProvaCommandRepository
{
    public function create(request $request): Prova
    {
        $prova = new Prova();
        $prova = $this->save($prova, $request);

        return $prova;
    }

    private function save(Prova $prova, request $request): Prova
    {
        $prova->tipo_prova  = $request->get('tipo');
        $prova->data        = $request->get('data');
        $prova->save();

        return $prova;
    }
}