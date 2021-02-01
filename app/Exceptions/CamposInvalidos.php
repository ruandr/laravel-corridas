<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class CamposInvalidos extends Exception
{
    protected $message = 'Campos enviados são inválidos ou não foram informados';
}