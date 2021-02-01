<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Queries\ProvaResultadoQueryRepository;
use App\Repositories\Queries\ProvaCorredorQueryRepository;
use App\Repositories\Commands\ProvaResultadoCommandRepository;
use App\Enums\TipoProvasEnum;
use App\Enums\ProvasIdadesEnum;
use App\Exceptions\CamposInvalidos;
use App\Exceptions\HoraInvalida;
use App\Exceptions\ProvaCorredorInvalida;
use App\Exceptions\ResultadoJaCadastrado;

final class ProvaResultadoService
{
    private $provaResultadoQueries;
    private $provaCorredorQueries;
    private $provaResultadoCommands;

    public function __construct(
        ProvaResultadoQueryRepository $provaResultadoQueries,
        ProvaCorredorQueryRepository $provaCorredorQueries,
        ProvaResultadoCommandRepository $provaResultadoCommands
    ){
        $this->provaResultadoQueries  = $provaResultadoQueries;
        $this->provaCorredorQueries     = $provaCorredorQueries;
        $this->provaResultadoCommands = $provaResultadoCommands;
    }

    public function create(request $request): array
    {
        $createResponse = [
            'created'   => false,
            'data'      => []
        ];
        
        $validator = Validator::make($request->all(), [
            'id_corredor'   => 'required|integer',
            'id_prova'      => 'required|integer',
            'hora_inicio'   => 'required|size:5',
            'hora_fim'      => 'required|size:5'
        ]);

        if ($validator->fails()) {
            throw new CamposInvalidos();
        }


        $provaCorredor = $this->provaCorredorQueries->getByExternalIds(
            (int) $request->get('id_prova'),
            (int) $request->get('id_corredor')
        );
        

        if (is_null($provaCorredor)) {
            throw new ProvaCorredorInvalida();
        }

        $numberResults = $this->provaResultadoQueries->countResultsByProvaCorredores($provaCorredor->id);

        if ($numberResults > 0) {
            throw new ResultadoJaCadastrado();
        }

        if (!$this->validTime($request->get('hora_inicio'))) {
            throw new HoraInvalida('hora início');
        }

        if (!$this->validTime($request->get('hora_fim'))) {
            throw new HoraInvalida('hora fim');
        }

        if (!$this->validStartAndEnd($request->get('hora_inicio'), $request->get('hora_fim'))) {
            throw new HoraInvalida();
        }

        $request = $request->all();
        $request['id_prova_corredor']   = $provaCorredor->id;
        $request['inicio']              = $provaCorredor->data_prova_en . ' ' . $request['hora_inicio'] . ':00';
        $request['fim']                 = $provaCorredor->data_prova_en . ' ' . $request['hora_fim'] . ':00';

        $provaResultado = $this->provaResultadoCommands->create($request);

        $createResponse['created'] = true;
        $createResponse['data'] = $provaResultado->toArray();

        return $createResponse;
    }

    public function getGeneralClassification(): array
    {
        $response = [];

        $types = TipoProvasEnum::toArray();

        foreach ($types as $name => $type) {
            $classification = $this->provaResultadoQueries
                                ->getResultByType($type);
            
            $classification = $this->getListWithPosition($classification->toArray());
            $response[$name] = $classification;
        }

        return $response;
    }

    public function listClassificationByAge(string $agePeriod): array
    {
        $response = [];

        $agePeriods = $this->treatAgePeriod($agePeriod);
        
        foreach ($agePeriods as $agePeriod) {
            $key = $agePeriod['from'] . '-' . $agePeriod['to'];
            $classificationList = $this->getClassificationByAgeAndTypes($agePeriod['from'], $agePeriod['to']);
            $response[$key] = $classificationList;
        }

        return $response;
    }

    private function getClassificationByAgeAndTypes(string $from, string $to): array
    {
        $types = TipoProvasEnum::toArray();
        $data = [];

        foreach ($types as $name => $type) {
            $classification = $this->provaResultadoQueries
                                ->getResultByAgeAndType($from, $to, $type);
            
            $classification = $this->getListWithPosition($classification->toArray());
            $data[$name] = $classification;
        }
        return $data;
    }

    public function getPendingResults(): array
    {
        $pendingResults = $this->provaResultadoQueries->getPendingResults();
        
        return $pendingResults;
    }

    public function getRandValidHours(): array
    {
        $hours = [
            'start' => '',
            'end'   => ''
        ];

        $startHour    = '0' . rand(8, 11);
        $startMinutes = rand(10, 59);
        $hours['start'] = $startHour . ':' . $startMinutes; 
        
        $endHour    = '0' . rand(12, 15);
        $endMinutes = rand(10, 59);
        $hours['end'] = $endHour . ':' . $endMinutes;

        return $hours;
    }

    private function validTime(string $time)
    {
        $time = explode(":", $time);

        if (sizeof($time) != 2) {
            return false;
        }

        $hour   =  $time[0];
        $minute =  $time[1];

        if ($hour <= 0 || $hour > 23) {
            return false;
        }

        if ($minute < 0 || $minute > 60) {
            return false;
        }

        return true;
    }

    private function validStartAndEnd(string $start, string $end): bool
    {
        $startMinutes   = $this->getMinutesFromHour($start);
        $endMinutes     = $this->getMinutesFromHour($end);

        return $startMinutes < $endMinutes ? true : false;
    }

    
    private function getMinutesFromHour(string $hour): int
    {
        $hour = explode(':', $hour);
        $minutes = ((int) $hour[0] * 60) + (int) $hour[1];

        return $minutes;
    }

    private function treatAgePeriod($agePeriod): array
    {
        $agePeriods = [];
        if ($agePeriod == 'all') {
            $agePeriods = ProvasIdadesEnum::toArray();
        } else {
            $agePeriods = [
                $agePeriod
            ];
        }

        $agePeriods = $this->separeteAges($agePeriods);

        return $agePeriods;
    }

    private function separeteAges(array $agePeriods): array
    {
        $separetedAges = [];
        foreach ($agePeriods as $age) {
            $age = $age == '56-more' ? '56-999' : $age;
            $age = explode("-", $age);
            $separetedAges[] = [
                'from'  => $age[0],
                'to'    => $age[1]
            ];
        }

        return $separetedAges;
    }

    private function getListWithPosition(array $list): array
    {
        $newList = [];
        foreach ($list as $position => $register) {
            $register = get_object_vars($register);
            $register['posicao'] = $position + 1;
            $newList[$position + 1] = $register;
        }

        return $newList;
    }
}
