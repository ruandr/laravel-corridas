<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class ProvaJaCadastrada extends Exception
{
    protected $message = 'Já existe uma prova deste tipo cadastrada na mesma data';
}