<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class HoraInvalida extends Exception
{
    protected $message = 'A hora informada não é válida';

    public function __construct(string $tipo_hora = 'hora')
    {
        $this->message = 'A ' . $tipo_hora . ' informada não é válida';
    }

}