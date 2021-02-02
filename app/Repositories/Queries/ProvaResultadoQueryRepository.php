<?php

declare(strict_types=1);

namespace App\Repositories\Queries;

use DB;
use stdClass;
use App\Models\ProvaResultado;
use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;
use App\Enums\ProvasIdadesEnum;

class ProvaResultadoQueryRepository
{
    public function find(int $id): ?ProvaResultado
    {
        return ProvaResultado::with('provaCorredor')->where('id', $id)->first();
    }

    public function getById(int $id): ?stdClass
    {
        $provaResultado = $this->baseQuery()
                            ->where('id', $id)
                            ->first();
        
        return $provaResultado;
    }

    public function countResultsByProvaCorredores(int $idProvaCorredor): int
    {
        $countProvasResultados = DB::table('provas_resultados')
                                    ->where('id_prova_corredor', $idProvaCorredor)
                                    ->count();

        return $countProvasResultados;
    }

    public function getByExternalIds(int $id_prova, int $id_corredor): ?stdClass
    {
        $provaResultado = $this->baseQuery()
                            ->where('provas_corredores.id_prova', $id_prova)
                            ->where('provas_corredores.id_corredor', $id_corredor)
                            ->first();
        return $provaResultado;
    }

    public function getResultByAgeAndType(string $from, string $to, string $type): ?Collection
    {
        $provasResultados = $this->baseQuery()
                                ->where('provas.tipo_prova', $type)
                                ->whereRaw('TIMESTAMPDIFF (YEAR,corredores.data_nascimento,CURDATE()) >= ' . $from)
                                ->whereRaw('TIMESTAMPDIFF (YEAR,corredores.data_nascimento,CURDATE()) <= ' . $to)
                                ->get();
        return $provasResultados;
    }

    public function getResultByType(string $type): ?Collection
    {
        $provasResultados = $this->baseQuery()
                                ->where('provas.tipo_prova', $type)
                                ->get();

        return $provasResultados;
    }

    public function getPendingResults(): array
    {
        $resultadosPendentes = DB::table('provas_corredores')
                            ->leftJoin(
                                'provas_resultados',
                                'provas_corredores.id',
                                'provas_resultados.id_prova_corredor'
                            )
                            ->whereRaw('ISNULL(provas_resultados.id)')
                            ->pluck('provas_corredores.id')
                            ->toArray();
        return $resultadosPendentes;
    }

    private function baseQuery(): Builder
    {
        $query = DB::table('provas_resultados')
                    ->join('provas_corredores', 'provas_corredores.id', 'provas_resultados.id_prova_corredor')
                    ->join('provas', 'provas.id', 'provas_corredores.id_prova')
                    ->join('corredores', 'corredores.id', 'provas_corredores.id_corredor')
                    ->select(
                        'provas_resultados.id',
                        'provas_corredores.id as id_prova_corredor',
                        'provas.id as id_prova',
                        'corredores.id as id_corredor',
                        'corredores.nome',
                        'corredores.cpf',
                        'corredores.data_nascimento',
                        DB::raw('provas.data as data_prova'),
                        DB::raw('TIMESTAMPDIFF (YEAR,corredores.data_nascimento,CURDATE()) as idade'),
                        DB::raw('CONCAT(provas.tipo_prova, "KM") as tipo_prova'),
                        DB::raw(
                            'TIMESTAMPDIFF(
                                MINUTE, provas_resultados.inicio, provas_resultados.fim
                            ) as tempo_prova_minutos'
                        ),
                        'provas_resultados.inicio',
                        'provas_resultados.fim'
                    )
                    ->orderByRaw('TIMEDIFF(provas_resultados.inicio, provas_resultados.fim) DESC');
        return $query;
    }
}
