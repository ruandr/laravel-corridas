<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class CorredorMenorDeIdade extends Exception
{
    protected $message = 'Não é permitida a inscrição de menores de idade';
}