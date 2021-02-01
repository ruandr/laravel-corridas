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
}
