<?php

declare(strict_types=1);

namespace App\Repositories\Queries;

use App\Models\Corredor;
use Illuminate\Database\Eloquent\Collection;

class CorredorQueryRepository
{
    public function getById(int $id): ?Corredor
    {
        return Corredor::find($id);
    }

    public function all(): ?Collection
    {
        return Corredor::all();

    }
}
