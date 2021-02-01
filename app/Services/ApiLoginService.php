<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\Queries\UserQueryRepository;

final class ApiLoginService
{
    private $userQueries;

    public function __construct(UserQueryRepository $userQueries)
    {
        $this->userQueries = $userQueries;
    }

        

}
