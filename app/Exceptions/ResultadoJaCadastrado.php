<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class ResultadoJaCadastrado extends Exception
{
    protected $message = 'Resultado da corrida já cadastrado';
}