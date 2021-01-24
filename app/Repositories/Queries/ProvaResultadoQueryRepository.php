<?php

declare(strict_types=1);

namespace App\Repositories\Queries;

use DB;

class ProvaResultadoQueryRepository
{
    public function getById(int $id): ?DB
    {
        $provaResultado = $this->baseQuery()
                            ->where('id', $id)
                            ->first();
        
        return $provaResultado;
    }

    public function getByExternalIds(int $id_prova, int $id_corredor): ?DB
    {
        $provaResultado = $this->baseQuery()
                            ->where('provas_corredores.id_prova', $id_prova)
                            ->where('provas_corredores.id_corredor', $id_corredor)
                            ->first();
        return $provaResultado;
    }

    public function all(): DB
    {
        $provasResultados = $this->baseQuery()
                                ->get();
        
        return $provasResultados;
    }

    public function getResultByYear(string $from, string $to): DB
    {
        $provasResultados = $this->baseQuery()
                                ->whereRaw('TIMESTAMPDIFF (YEAR,corredores.data_nascimento,CURDATE()) >= ' . $from)
                                ->whereRaw('TIMESTAMPDIFF (YEAR,corredores.data_nascimento,CURDATE()) <= ' . $to)
                                ->get();
    }

    private function baseQuery(): DB
    {
        $query = DB::table('provas_resultados')
                    ->join('provas_corredores', 'provas_corredores.id', 'provas_resultados.id_prova_corredor')
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
                        DB::raw('CONTAT(provas.tipo, "KM") as tipo_prova'),
                        'provas_resultados.inicio',
                        'provas_resultados.fim'
                    )
                    ->orderByRaw('TIMEDIFF(provas_resultados.inicio, provas_resultados.fim)');
        return $query;
    }
}
