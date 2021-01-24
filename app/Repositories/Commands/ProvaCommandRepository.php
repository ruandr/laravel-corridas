<?php

declare(strict_types=1);

namespace App\Respositories\Commands;

use App\Models\Prova;

class ProvaCommandRepository
{
    public function create(request $request): Prova
    {
        $prova = new Prova;
        $prova = $this->save($prova, $request);

        return $prova;
    }

    public function update(request $request): Prova
    {
        $prova = Prova::find($request->get('id'));
        $prova = $this->save($prova, $request);

        return $prova;
    }

    public function delete(int $id): void
    {
        $prova = Prova::find($id);
        $prova->delete();
    }

    private function save(Prova $prova, request $request): Prova
    {
        $prova->tipo_prova  = $request->get('proof_type');
        $prova->data        = $request->get('date');
        return $prova;
    }
}