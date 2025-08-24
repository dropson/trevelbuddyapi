<?php

declare(strict_types=1);

namespace App\Enums;

enum LanguageLevelEnum: string
{
    case BEGINNER = 'beginer';
    case INTERMEDIATE = 'intermediate';
    case FLUENT = 'fluent';
    case NATIVE = 'native';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
