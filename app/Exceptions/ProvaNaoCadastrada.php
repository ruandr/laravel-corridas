<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class ProvaNaoCadastrada extends Exception
{
    protected $message = 'Não existe nenhuma prova com o ID informado';
}