<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class DataInvalida extends Exception
{
    protected $message = 'A data informada não é válida';
}