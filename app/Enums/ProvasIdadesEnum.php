<?php

declare(strict_types=1);

namespace App\Enums;

use App\Enums\Enum;

class ProvasIdadesEnum extends Enum
{
    public const ANOS_18_25     = '18-25';
    public const ANOS_26_35     = '26-35';
    public const ANOS_36_45     = '36-45';
    public const ANOS_46_55     = '46-55';
    public const ANOS_56_999    = '56-999';

    public static $registers = [
        self::ANOS_18_25    => '18-25',
        self::ANOS_26_35    => '26-35',
        self::ANOS_36_45    => '36-45',
        self::ANOS_46_55    => '46-55',
        self::ANOS_56_999   => '56-999',
    ];
}
