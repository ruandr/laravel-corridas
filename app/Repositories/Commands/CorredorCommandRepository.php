<?php

declare(strict_types=1);

namespace App\Repositories\Commands;

use App\Models\Corredor;

class CorredorCommandRepository
{
    public function create(array $request): Corredor
    {
        $corredor = new Corredor();
        $corredor = $this->save($corredor, $request);
    
        return $corredor;
    }

    private function save(Corredor $corredor, array $request): Corredor
    {
        $corredor->nome             = $request['nome'];
        $corredor->cpf              = $request['cpf'];
        $corredor->data_nascimento  = $request['data_nascimento'];
        $corredor->save();

        return $corredor;
    }
}
