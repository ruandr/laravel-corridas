<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Helpers\ApiResponse;
use App\Services\ProvaResultadoService;
use App\Exceptions\CamposInvalidos;
use App\Exceptions\HoraInvalida;
use App\Exceptions\ProvaCorredorInvalida;
use App\Exceptions\ResultadoJaCadastrado;
use App\Exceptions\ResultadoNaoCadastrado;

class ProvasResultadosController extends Controller
{
    private $provaResultadoService;
    private $apiResponse;

    public function __construct(
        ProvaResultadoService $provaResultadoService,
        ApiResponse $apiResponse
    ){
        $this->provaResultadoService    = $provaResultadoService;
        $this->apiResponse              = $apiResponse;
    }

    public function create(Request $request): JsonResponse
    {
        try {
            $response = $this->apiResponse->getDefaultResponse();
            $provaResultado = $this->provaResultadoService->create($request);
    
            $response['data'] = $provaResultado['data'];
    
            return response()->json($response, 200);
        } catch (CamposInvalidos $ex) {
            $response = $this->apiResponse->getErrorResponse($ex->getMessage());

            return response()->json($response, 400);
        } catch (HoraInvalida $ex) {
            $response = $this->apiResponse->getErrorResponse($ex->getMessage());

            return response()->json($response, 400);
        } catch (ProvaCorredorInvalida $ex) {
            $response = $this->apiResponse->getErrorResponse($ex->getMessage());

            return response()->json($response, 400);
        } catch (ResultadoJaCadastrado $ex) {
            $response = $this->apiResponse->getErrorResponse($ex->getMessage());

            return response()->json($response, 400);
        } catch (\Throwable $th) {
            $response = $this->apiResponse->getErrorResponse('Internal Error');

            return response()->json($response, 500);
        }
    }

    public function find(int $id): JsonResponse
    {
        try {
            $response = $this->apiResponse->getDefaultResponse();
            $provaResultado = $this->provaResultadoService->find($id);
            
            $response['data'] = $provaResultado;

            return response()->json(['data' => $response], 200);
        } catch (ResultadoNaoCadastrado $ex) {
            $response = $this->apiResponse->getErrorResponse($ex->getMessage());

            return response()->json($response, 400);
        } catch (\Throwable $th) {
            $response = $this->apiResponse->getErrorResponse('Internal Error');

            return response()->json(['data' => $response], 500);
        }
    }

    public function listClassificationByAge(string $agePeriod = 'all'): JsonResponse
    {
        try {
            $response = $this->apiResponse->getDefaultResponse();
            $provasResultados = $this->provaResultadoService->listClassificationByAge($agePeriod);
            
            $response['data'] = $provasResultados;

            return response()->json(['data' => $response], 200);
        } catch (\Throwable $th) {
            $response = $this->apiResponse->getErrorResponse('Internal Error');

            return response()->json(['data' => $response], 500);
        }
    }

    public function listGeneralClassification(): JsonResponse
    {
        try {
            $response = $this->apiResponse->getDefaultResponse();
            $provasResultados = $this->provaResultadoService->getGeneralClassification();

            $response['data'] = $provasResultados;
            return response()->json(['data' => $provasResultados], 200);
        } catch (\Throwable $th) {
            $response = $this->apiResponse->getErrorResponse('Internal Error');

            return response()->json(['data' => $response], 500);
        }
    }

}
