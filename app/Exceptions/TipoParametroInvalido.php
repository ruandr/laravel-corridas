<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class TipoParametroInvalido extends Exception
{
    protected $message = 'Tipo de parâmetro inválido';
}