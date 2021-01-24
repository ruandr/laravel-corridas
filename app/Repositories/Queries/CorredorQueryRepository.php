<?php

declare(strict_types=1);

namespace App\Repositories\Queries;

use App\Models\Corredor;

class CorredorQueryRepository
{
    public function getById(int $id): ?Corredor
    {
        return Corredor::find($id);
    }

    public function all(): Corredor
    {
        return Corredor::all();
    }
}
