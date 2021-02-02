<?php

declare(strict_types=1);

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Queries\CorredorQueryRepository;
use App\Repositories\Commands\CorredorCommandRepository;
use App\Exceptions\CamposInvalidos;
use App\Exceptions\CorredorMenorDeIdade;
use App\Exceptions\CpfInvalido;
use App\Exceptions\CorredorNaoCadastrado;

final class CorredorService
{
    private $corredorQueries;
    private $corredorCommands;

    public function __construct(
        CorredorQueryRepository $corredorQueries,
        CorredorCommandRepository $corredorCommands
    ){
        $this->corredorQueries  = $corredorQueries;
        $this->corredorCommands = $corredorCommands;
    }

    public function create(request $request): array
    {
        $createResponse = [
            'data'      => []
        ];
        
        $validator = Validator::make($request->all(), [
            'nome'              => 'required|max:255',
            'cpf'               => 'required',
            'data_nascimento'   => 'required|date'
        ]);

        if ($validator->fails()) {
            throw new CamposInvalidos();
        }
        
        if (!$this->validateCpf($request->get('cpf'))) {
            throw new CpfInvalido();
        }

        if (!$this->validateAge($request->get('data_nascimento'))) {
            throw new CorredorMenorDeIdade();
        }

        $request = $request->all();
        $request['cpf'] = $this->maskCpf($request['cpf']);
        
        $corredor = $this->corredorCommands->create($request);

        $createResponse['data'] = $corredor->toArray();

        return $createResponse;
    }

    public function find(int $id): array
    {
        $corredor = $this->corredorQueries->getById($id);

        if (is_null($corredor)) {
            throw new CorredorNaoCadastrado();
        }

        return $corredor->toArray();
    }

    public function getAll(): array
    {
        $corredores = $this->corredorQueries->all();

        return $corredores->toArray();
    }

    public function getByCpf(string $cpf): array
    {
        if (!$this->validateCpf($cpf)) {
            throw new CpfInvalido();
        }

        $cpf = $this->maskCpf($cpf);

        $corredor = $this->corredorQueries->getByCpf($cpf);

        if (is_null($corredor)) {
            throw new CorredorNaoCadastrado();
        }

        return $corredor->toArray();
    }

    private function validateAge(string $birth): bool
    {
        $birth  = Carbon::parse($birth);
        $now    = Carbon::now();

        $diff = $now->diffInYears($birth);

        if ($diff < 18) {
            return false;
        }

        return true;
    }

    private function maskCpf(string $cpf): string
    {
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);
        $mask = "###.###.###-##";

        $cpf = str_replace(" ", "", $cpf);
        for ($i = 0; $i < strlen($cpf); $i++) {
            $mask[strpos($mask, "#")] = $cpf[$i];
        }

        return $mask;
    }

    private function validateCpf(string $cpf): bool
    {
        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        if (strlen($cpf) != 11) {
            return false;
        }
    
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
    
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }
}
