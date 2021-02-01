<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class CorredorIndisponivel extends Exception
{
    protected $message = 'O corredor já possui uma prova agendada para esta data';
}