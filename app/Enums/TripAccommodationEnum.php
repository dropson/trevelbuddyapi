<?php

declare(strict_types=1);

namespace App\Enums;

enum TripAccommodationEnum: string
{
    case CAMPSIDE = 'campside';
    case HOTEL = 'hotel';
    case HOSTEL = 'hostel';
    case HOMESTAY = 'homestay';
    case MIXED = 'mixed';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::CAMPSIDE => 'Campside',
            self::HOTEL => 'Hotel',
            self::HOSTEL => 'Hostel',
            self::HOMESTAY => 'Homestay',
            self::MIXED => 'Mixed',
        };
    }
}
