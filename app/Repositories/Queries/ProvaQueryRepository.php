<?php

declare(strict_types=1);

namespace App\Repositories\Queries;

use App\Models\Prova;
use Illuminate\Database\Eloquent\Collection;

class ProvaQueryRepository
{
    public function getById(int $id): ?Prova
    {
        return Prova::find($id);
    }

    public function all(): ?Collection
    {
        return Prova::all();
    }

    public function getProvaByDateAndType(string $type, string $date): ?Prova
    {
        return Prova::where('tipo_prova', $type)
                    ->where('data', $date)
                    ->first();
    }
}
