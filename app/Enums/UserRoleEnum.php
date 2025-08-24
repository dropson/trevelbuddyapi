<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRoleEnum: string
{
    case TRAVELER = 'traveler';
    case GUIDE = 'guide';
    case MODERATOR = 'moderator';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
