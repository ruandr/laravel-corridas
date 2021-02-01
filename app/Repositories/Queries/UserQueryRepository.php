<?php

declare(strict_types=1);

namespace App\Repositories\Queries;

use App\Models\User;

class UserQueryRepository
{
    public function getById(int $id): ?User
    {
        return User::find($id);
    }

    public function getByAccessToken(string $accessToken): ?User
    {
        return User::where('accessToken', $accessToken)->first();
    }
}
