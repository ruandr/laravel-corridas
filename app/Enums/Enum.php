<?php

declare(strict_types=1);

namespace App\Enums;

use ReflectionClass;

abstract class Enum
{
    final public static function toArray(): array
    {
        return (new ReflectionClass(static::class))->getConstants();
    }
}
