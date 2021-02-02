<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Helpers\ApiResponse;
use App\Services\ProvaCorredorService;
use App\Exceptions\CamposInvalidos;
use App\Exceptions\CorredorNaoCadastrado;
use App\Exceptions\ProvaNaoCadastrada;
use App\Exceptions\CorredorIndisponivel;
use App\Exceptions\ProvaCorredorInvalida;

class ProvasCorredoresController extends Controller
{
    private $provaCorredorService;
    private $apiResponse;

    public function __construct(
        ProvaCorredorService $provaCorredorService,
        ApiResponse $apiResponse
    ){
        $this->provaCorredorService  = $provaCorredorService;
        $this->apiResponse      = $apiResponse;
    }

    public function create(Request $request): JsonResponse
    {
        try {
            $response = $this->apiResponse->getDefaultResponse();
            $provaCorredor = $this->provaCorredorService->create($request);
            
            $response['data'] = $provaCorredor['data'];
    
            return response()->json($response, 200);
        } catch (CamposInvalidos $ex) {
            $response = $this->apiResponse->getErrorResponse($ex->getMessage());

            return response()->json($response, 400);
        } catch (CorredorNaoCadastrado $ex) {
            $response = $this->apiResponse->getErrorResponse($ex->getMessage());

            return response()->json($response, 400);
        } catch (ProvaNaoCadastrada $ex) {
            $response = $this->apiResponse->getErrorResponse($ex->getMessage());

            return response()->json($response, 400);
        } catch (CorredorIndisponivel $ex) {
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
            $provasCorredores = $this->provaCorredorService->getAll();
            
            $response['data'] = $provasCorredores;
    
            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response = $this->apiResponse->getErrorResponse('Internal Error');

            return response()->json($response, 500);
        }
    }

    public function find(int $idProva, int $idCorredor): JsonResponse
    {
        try {
            $response = $this->apiResponse->getDefaultResponse();
            $provaCorredor = $this->provaCorredorService->findByExternalIds($idProva, $idCorredor);
            
            $response['data'] = $provaCorredor;
    
            return response()->json($response, 200);
        } catch (ProvaCorredorInvalida $ex) {
            $response = $this->apiResponse->getErrorResponse($ex->getMessage());

            return response()->json($response, 400);
        } catch (\Throwable $th) {
            $response = $this->apiResponse->getErrorResponse('Internal Error');

            return response()->json($response, 500);
        }
    }
}
