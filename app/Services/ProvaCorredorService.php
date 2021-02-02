<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Queries\ProvaCorredorQueryRepository;
use App\Repositories\Queries\ProvaQueryRepository;
use App\Repositories\Queries\CorredorQueryRepository;
use App\Repositories\Commands\ProvaCorredorCommandRepository;
use App\Exceptions\CamposInvalidos;
use App\Exceptions\CorredorNaoCadastrado;
use App\Exceptions\ProvaNaoCadastrada;
use App\Exceptions\CorredorIndisponivel;
use App\Exceptions\ProvaCorredorInvalida;

final class ProvaCorredorService
{
    private $provaCorredorQueries;
    private $provaCorredorCommands;
    private $provaQueries;
    private $corredorQueries;


    public function __construct(
        ProvaCorredorQueryRepository $provaCorredorQueries,
        ProvaCorredorCommandRepository $provaCorredorCommands,
        ProvaQueryRepository $provaQueries,
        CorredorQueryRepository $corredorQueries
    ){
        $this->provaCorredorQueries     = $provaCorredorQueries;
        $this->provaCorredorCommands    = $provaCorredorCommands;
        $this->provaQueries             = $provaQueries;
        $this->corredorQueries          = $corredorQueries;
    }

    public function create(request $request): array
    {
        $createResponse = [
            'created'   => false,
            'data'      => []
        ];

        $validator = Validator::make($request->all(), [
            'id_corredor'       => 'required|integer',
            'id_prova'          => 'required|integer'
        ]);

        if ($validator->fails()) {
            throw new CamposInvalidos();
        }

        $validCorredor = $this->corredorQueries->getById((int) $request->id_corredor);

        if (is_null($validCorredor)) {
            throw new CorredorNaoCadastrado();
        }

        $validProva = $this->provaQueries->getById((int) $request->id_prova);

        if (is_null($validProva)) {
            throw new ProvaNaoCadastrada();
        }

        $countCorredorInDate = $this->provaCorredorQueries->countCorredorInDate(
            (int) $request->get('id_corredor'),
            $validProva->data
        );

        if ($countCorredorInDate > 0) {
            throw new CorredorIndisponivel();
        }

        $provaCorredor = $this->provaCorredorCommands->create($request);

        $createResponse['created']  = true;
        $createResponse['data']     = $provaCorredor->toArray();

        return $createResponse;
    }

    public function getAll(): array
    {
        $provasCorredores = $this->provaCorredorQueries->all();

        return $provasCorredores->toArray();
    }

    public function findByExternalIds(int $idProva, int $idCorredor): array
    {
        $provaCorredor = $this->provaCorredorQueries->findByExternalIds($idProva, $idCorredor);

        if (is_null($provaCorredor)) {
            throw new ProvaCorredorInvalida();
        }

        return $provaCorredor->toArray();
    }

    public function getValidsRandomExternalIds(): array
    {
        $provas = $this->provaQueries->all()->toArray();
        $corredores = $this->corredorQueries->all()->toArray();

        $tries = 0;
        $valid = 0;

        while ($valid == 0 && $tries < 5) {
            $tries++;
            $ids = $this->getRandomIds($provas, $corredores);

            $exists = $this->provaCorredorQueries->countByExternalIds($ids['idProva'], $ids['idCorredor']);

            if ($exists == 0) {
                $valid = 1;
            } else {
                $ids = [
                    'idProva'    => 0,
                    'idCorredor' => 0
                ];
            }
        }
        
        return $ids;
    }

    private function getRandomIds(array $provas, array $corredores): array
    {
        $randProva = array_rand($provas);
        $randCorredor = array_rand($corredores);
    
        $ids = [
            'idProva'       => $provas[$randProva]['id'],
            'idCorredor'    => $corredores[$randCorredor]['id']
        ];

        return $ids;
    }
}
