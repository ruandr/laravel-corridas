<?php

declare(strict_types=1);

namespace App\Repositories\Queries;

use App\Models\Prova;

class ProvaQueryRepository
{
    public function getById(int $id): Prova
    {
        return Prova::find($id);
    }

    public function all(): Prova
    {
        return Prova::all();
    }
}
