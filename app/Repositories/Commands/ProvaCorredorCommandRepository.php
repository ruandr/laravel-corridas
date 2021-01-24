<?php

declare(strict_types=1);

namespace App\Respositories\Commands;

use App\Models\ProvaCorredor;

class ProvaCorredorCommandRepository
{
    public function create(request $request): ProvaCorredor
    {
        $provaCorredor = new ProvaCorredor;
        $provaCorredor->id_prova    = $request->get('proof_id');
        $provaCorredor->id_corredor = $request->get('runner_id');
        $provaCorredor->save();

        return $provaCorredor;
    }

    public function delete(int $idProva, int $idCorredor): void
    {
        $provaCorredor = ProvaCorredor::where('id_prova', $idProva)
                                    ->where('id_corredor', $idCorredor)
                                    ->first();
        $provaCorredor->delete();
    }
}
