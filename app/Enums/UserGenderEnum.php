<?php

declare(strict_types=1);

namespace App\Enums;

enum UserGenderEnum: string
{
    case MALE = 'male';
    case FEMALE = 'female';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
