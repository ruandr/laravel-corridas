<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Helpers\ApiResponse;
use App\Services\ProvaService;
use App\Exceptions\CamposInvalidos;
use App\Exceptions\TipoProvaInvalido;
use App\Exceptions\DataInvalida;
use App\Exceptions\ProvaJaCadastrada;
use App\Exceptions\TipoParametroInvalido;
use App\Exceptions\ProvaNaoCadastrada;

class ProvasController extends Controller
{
    private $provaService;
    private $apiResponse;

    public function __construct(
        ProvaService $provaService,
        ApiResponse $apiResponse
    ){
        $this->provaService  = $provaService;
        $this->apiResponse      = $apiResponse;
    }

    public function create(Request $request): JsonResponse
    {
        try {
            $response = $this->apiResponse->getDefaultResponse();
            $prova = $this->provaService->create($request);
    
            $response['data'] = $prova['data'];
    
            return response()->json($response, 200);
        } catch (CamposInvalidos $ex) {
            $response = $this->apiResponse->getErrorResponse($ex->getMessage());

            return response()->json($response, 400);
        } catch (TipoProvaInvalido $ex) {
            $response = $this->apiResponse->getErrorResponse($ex->getMessage());

            return response()->json($response, 400);
        } catch (DataInvalida $ex) {
            $response = $this->apiResponse->getErrorResponse($ex->getMessage());

            return response()->json($response, 400);
        } catch (ProvaJaCadastrada $ex) {
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

            $provas = $this->provaService->getAll();

            $response['data'] = $provas;

            return response()->json($response, 200);
        } catch (\Throwable $th) {
            $response = $this->apiResponse->getErrorResponse('Internal Error');

            return response()->json($response, 500);
        }
    }

    public function getByParam(string $paramType, string $param): JsonResponse
    {
        try {
            $response = $this->apiResponse->getDefaultResponse();
            $prova = $this->provaService->getByParam($paramType, $param);
    
            $response['data'] = $prova;
    
            return response()->json($response, 200);
        } catch (TipoParametroInvalido $ex) {
            $response = $this->apiResponse->getErrorResponse($ex->getMessage());

            return response()->json($response, 400);
        } catch (TipoProvaInvalido $ex) {
            $response = $this->apiResponse->getErrorResponse($ex->getMessage());

            return response()->json($response, 400);
        } catch (DataInvalida $ex) {
            $response = $this->apiResponse->getErrorResponse($ex->getMessage());

            return response()->json($response, 400);
        } catch (ProvaNaoCadastrada $ex) {
            $response = $this->apiResponse->getErrorResponse($ex->getMessage());

            return response()->json($response, 400);
        } catch (\Throwable $th) {
            $response = $this->apiResponse->getErrorResponse('Internal Error');

            return response()->json($response, 500);
        }
    }
}
