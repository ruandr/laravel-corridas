<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class ProvaCorredorInvalida extends Exception
{
    protected $message = 'Não existe nenhuma corrida marcada com os IDs informados';
}