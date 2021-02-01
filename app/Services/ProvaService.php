<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Queries\ProvaQueryRepository;
use App\Repositories\Commands\ProvaCommandRepository;
use App\Enums\TipoProvasEnum;
use App\Exceptions\CamposInvalidos;
use App\Exceptions\TipoProvaInvalido;
use App\Exceptions\DataInvalida;
use App\Exceptions\ProvaJaCadastrada;

final class ProvaService
{
    private $provaQueries;
    private $provaCommands;

    public function __construct(
        ProvaQueryRepository $provaQueries,
        ProvaCommandRepository $provaCommands
    ){
        $this->provaQueries   = $provaQueries;
        $this->provaCommands  = $provaCommands;
    }
    
    public function create(request $request): array
    {
        $createResponse = [
            'created'   => false,
            'data'      => []
        ];

        $validator = Validator::make($request->all(), [
            'tipo'  => 'required|max:255',
            'data'  => 'required|date'
        ]);

        if ($validator->fails()) {
            throw new CamposInvalidos();
        }
        
        if (!$this->validateType($request->get('tipo'))) {
            throw new TipoProvaInvalido();
        }

        if (!$this->validateDateFormat($request->get('data'))) {
            throw new DataInvalida();
        }

        $provaExists = $this->provaQueries->getProvaByDateAndType(
            $request->get('tipo'),
            $request->get('data')
        );

        if (!is_null($provaExists)) {
            throw new ProvaJaCadastrada();
        }

        $prova = $this->provaCommands->create($request);

        $createResponse['created'] = true;
        $createResponse['data'] = $prova->toArray();

        return $createResponse;
    }

    private function validateType(string $type): bool
    {
        $validTypes = TipoProvasEnum::toArray();

        return in_array($type, $validTypes);
    }

    private function validateDateFormat(string $date): bool
    {
        $date = explode('-', $date);

        return sizeof($date) == 3 ? true : false;
    }
}
