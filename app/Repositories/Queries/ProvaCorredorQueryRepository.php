<?php

declare(strict_types=1);

namespace App\Repositories\Queries;

use DB;
use App\Models\ProvaCorredor;

class ProvaCorredorQueryRepository
{
    public function getById(int $id): ?DB
    {
        $provaCorredor = $this->baseQuery()
                            ->where('id', $id)
                            ->first();

        return $provaCorredor;
    }

    public function getByExternalIds(int $idProva, int $idCorredor): ?DB
    {
        $provaCorredor = $this->baseQuery()
                            ->where('provas_corredores.id_prova', $idProva)
                            ->where('provas_corredores.id_corredor', $idCorredor)
                            ->first();
                            
        return $provaCorredor;
    }

    public function all(): DB
    {
        $provasCorredores = $this->baseQuery()
                                ->get();
        
        return $provasCorredores;
    }

    private function baseQuery(): DB
    {
        $query = DB::table('provas_corredores')
                    ->join('provas', 'prova.id', 'provas_corredores.id_prova')
                    ->join('corredores', 'corredores.id', 'prova_corredores.id')
                    ->select(
                        'provas_corredores.id',
                        'provas.id as id_prova',
                        'corredores.id as id_corredor',
                        'corredores.nome',
                        'corredores.cpf',
                        'corredores.data_nascimento',
                        DB::raw('TIMESTAMPDIFF (YEAR,corredores.data_nascimento,CURDATE()) as idade'),
                        DB::raw('DATE_FORMAT(provas.data,"%d/%m/%Y") as data_prova'),
                        DB::raw('CONTAT(provas.tipo, "KM") as tipo_prova')
                    );

        return $query;
    }
}
