<?php

namespace App\Http\Middleware;

use Closure;
use App\Repositories\Queries\UserQueryRepository;

class ApiRequest
{
    private $userQueries;

    public function __construct(UserQueryRepository $userQueries)
    {
        $this->userQueries = $userQueries;
    }

    public function handle($request, Closure $next)
    {
        $accessToken = $request->bearerToken();

        $validUser = $this->userQueries->getByAccessToken($accessToken);
        
        if (is_null($validUser)) {
            return response()->json(['status' => 'Token de acesso inválido'], 401);
        }

        return $next($request);
    }
}