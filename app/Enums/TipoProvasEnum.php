<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Enum;

class TipoProvasEnum extends Enum
{
    public const KM_3 = 'KM_3';
    public const KM_5 = 'KM_5';
    public const KM_10 = 'KM_10';
    public const KM_21 = 'KM_21';
    public const KM_42 = 'KM_42';

    public static $registers = [
        self::KM_3  => '3',
        self::KM_5  => '5',
        self::KM_10 => '10',
        self::KM_21 => '21',
        self::KM_42 => '42',
    ];
}
