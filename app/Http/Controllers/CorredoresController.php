<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\CorredorService;
use App\Helpers\ApiResponse;
use App\Exceptions\CamposInvalidos;
use App\Exceptions\CorredorMenorDeIdade;
use App\Exceptions\CpfInvalido;

class CorredoresController extends Controller
{
    private $corredorService;
    private $apiResponse;

    public function __construct(
        CorredorService $corredorService,
        ApiResponse $apiResponse
    ){
        $this->corredorService  = $corredorService;
        $this->apiResponse      = $apiResponse;
    }
    
    public function create(Request $request): JsonResponse
    {
        try {
            $response = $this->apiResponse->getDefaultResponse();
            $corredor = $this->corredorService->create($request);
            
            $response['data'] = $corredor['data'];
    
            return response()->json($response, 200);
        } catch (CamposInvalidos $ex) {
            $response = $this->apiResponse->getErrorResponse($ex->getMessage());

            return response()->json($response, 400);
        } catch (CorredorMenorDeIdade $ex) {
            $response = $this->apiResponse->getErrorResponse($ex->getMessage());

            return response()->json($response, 400);
        } catch (CpfInvalido $ex) {
            $response = $this->apiResponse->getErrorResponse($ex->getMessage());

            return response()->json($response, 400);
        } catch (\Throwable $th) {
            $response = $this->apiResponse->getErrorResponse('Internal Error');

            return response()->json($response, 500);
        }
    }

    public function all(): JsonResponse
    {
        try {
            $response = $this->apiResponse->getDefaultResponse();
            $corredores = $this->corredorService->getAll();
            
            $response['data'] = $corredores;

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response = $this->apiResponse->getErrorResponse('Internal Error');

            return response()->json($response, 500);
        }
    }

    public function getByCpf(string $cpf): JsonResponse
    {
        try {
            $response = $this->apiResponse->getDefaultResponse();
            $corredor = $this->corredorService->getByCpf($cpf);
            
            $response['data'] = $corredor;

            return response()->json($response, 200);
        } catch (CpfInvalido $ex) {
            $response = $this->apiResponse->getErrorResponse($ex->getMessage());

            return response()->json($response, 400);
        } catch (\Throwable $th) {
            $response = $this->apiResponse->getErrorResponse('Internal Error');

            return response()->json($response, 500);
        }
    }
}
