<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class CpfInvalido extends Exception
{
    protected $message = 'O CPF informado não é válido';
}