<?php

declare(strict_types=1);

namespace App\Enums;

enum TripAccommodationEnum: string
{
    case CAMPSIDE = 'Campside';
    case HOTEL = 'Hotel';
    case HOSTEL = 'Hostel';
    case HOMESTAY = 'Homestay';
    case MIXED = 'Mixed';

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
