<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class CorredorNaoCadastrado extends Exception
{
    protected $message = 'Não existe nenhum corredor com o ID informado';
}