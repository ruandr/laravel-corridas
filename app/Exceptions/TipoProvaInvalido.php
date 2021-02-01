<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class TipoProvaInvalido extends Exception
{
    protected $message = 'O tipo de prova informado não é válido';
}