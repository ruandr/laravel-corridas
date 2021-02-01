<?php

declare(strict_types=1);

namespace App\Repositories\Commands;

use App\Models\ProvaCorredor;
use Illuminate\Http\Request;

class ProvaCorredorCommandRepository
{
    public function create(request $request): ProvaCorredor
    {
        $provaCorredor = new ProvaCorredor();
        $provaCorredor->id_prova    = $request->get('id_prova');
        $provaCorredor->id_corredor = $request->get('id_corredor');
        $provaCorredor->save();

        return $provaCorredor;
    }
}
