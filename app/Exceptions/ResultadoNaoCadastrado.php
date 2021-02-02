<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

final class ResultadoNaoCadastrado extends Exception
{
    protected $message = 'Não foi encontrado nenhum resultado com o ID informado';
}