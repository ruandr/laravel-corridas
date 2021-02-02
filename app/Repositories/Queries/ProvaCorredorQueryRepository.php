<?php

declare(strict_types=1);

namespace App\Repositories\Queries;

use DB;
use stdClass;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Models\ProvaCorredor;

class ProvaCorredorQueryRepository
{
    public function find(int $id): ?ProvaCorredor
    {
        return ProvaCorredor::with(['prova', 'corredor'])->where('id', $id)->first();
    }

    public function getByIdResumed(int $id): ?stdClass
    {
        $provaCorredor = DB::table('provas_corredores')
                            ->join('provas', 'provas.id', 'provas_corredores.id_prova')
                            ->where('provas_corredores.id', $id)
                            ->select('provas_corredores.id', 'provas.data')
                            ->first();
        
        return $provaCorredor;
    }

    public function all(): ?Collection
    {
        return ProvaCorredor::with(['prova', 'corredor'])->get();
    }

    public function findByExternalIds(int $idProva, int $idCorredor): ?ProvaCorredor
    {
        return ProvaCorredor::with(['prova', 'corredor'])
                            ->where('id_prova', $idProva)
                            ->where('id_corredor', $idCorredor)
                            ->first();
    }

    public function getByExternalIds(int $idProva, int $idCorredor): ?stdClass
    {
        $provaCorredor = $this->baseQuery()
                            ->where('provas_corredores.id_prova', $idProva)
                            ->where('provas_corredores.id_corredor', $idCorredor)
                            ->first();
        return $provaCorredor;
    }

    public function countByExternalIds(int $idProva, int $idCorredor): int
    {
        $provaCorredor = DB::table('provas_corredores')
                            ->where('id_prova', $idProva)
                            ->where('id_corredor', $idCorredor)
                            ->count();

        return $provaCorredor;
    }

    public function countCorredorInDate(int $idCorredor, string $data): int
    {
        $countProvaCorredor = DB::table('provas_corredores')
                            ->join('provas', 'provas.id', 'provas_corredores.id_prova')
                            ->where('provas_corredores.id_corredor', $idCorredor)
                            ->where('provas.data', $data)
                            ->count();
        return $countProvaCorredor;
    }

    private function baseQuery(): Builder
    {
        $query = DB::table('provas_corredores')
                    ->join('provas', 'provas.id', 'provas_corredores.id_prova')
                    ->join('corredores', 'corredores.id', 'provas_corredores.id_corredor')
                    ->select(
                        'provas_corredores.id',
                        'provas.id as id_prova',
                        'corredores.id as id_corredor',
                        'corredores.nome',
                        'corredores.cpf',
                        'corredores.data_nascimento',
                        'provas.data as data_prova_en',
                        DB::raw('TIMESTAMPDIFF (YEAR,corredores.data_nascimento,CURDATE()) as idade'),
                        DB::raw('DATE_FORMAT(provas.data,"%d/%m/%Y") as data_prova'),
                        DB::raw('CONCAT(provas.tipo_prova, "KM") as tipo_prova')
                    );

        return $query;
    }
}
