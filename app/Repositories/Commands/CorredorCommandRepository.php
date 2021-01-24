<?php

declare(strict_types=1);

namespace App\Respositories\Commands;

use App\Models\Corredor;

class CorredorCommandRepository
{
    public function create(request $request): Corredor
    {
        $corredor = new Corredor;
        $corredor = $this->save($corredor, $request);
    
        return $corredor;
    }

    public function update(request $request): Corredor
    {
        $corredor = Corredor::find($request->get('id'));
        $corredor = $this->save($corredor, $request);

        return $corredor;
    }

    public function delete(int $id): void
    {
        $corredor = Corredor::find($id);
        $corredor->delete();
    }

    private function save(Corredor $corredor, request $request): Corredor
    {
        $corredor->nome             = $request->get('name');
        $corredor->cpf              = $request->get('cpf');
        $corredor->data_nascimento  = $request->get('birth');
        $corredor->save();

        return $corredor;
    }
}
