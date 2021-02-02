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

        if (is_null($accessToken)) {
            return response()->json(['status' => 'Token de acesso não informado'], 401);
        }

        try {
            $validUser = $this->userQueries->getByAccessToken($accessToken);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'Internal Error'], 500);
        }
        
        if (is_null($validUser)) {
            return response()->json(['status' => 'Token de acesso inválido'], 401);
        }

        return $next($request);
    }
}