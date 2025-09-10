<?php

declare(strict_types=1);

namespace App\Enums;

enum TripStatusEnum: string
{
    case DRAFT = 'draft';
    case PENDING = 'pending';
    case ACTIVE = 'active';
    case REJECTED = 'rejected';
    case COMPLETED = 'completed';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function userTransitions(): array
    {
        return match ($this) {
            self::DRAFT => [self::PENDING],
            self::PENDING => [self::DRAFT],
            self::ACTIVE => [self::DRAFT],
            self::REJECTED, => [self::PENDING, self::DRAFT],
            default => []
        };
    }

    public function moderatorTransitions(): array
    {
        return match ($this) {
            self::PENDING => [self::ACTIVE, self::REJECTED],
            self::ACTIVE, => [self::COMPLETED],
            default => []
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::PENDING => 'Pending',
            self::ACTIVE => 'Active',
            self::REJECTED => 'Rejected',
            self::COMPLETED => 'Completed',
        };
    }

    public function editableFields(): array
    {
        return match ($this) {
            self::DRAFT, self::REJECTED => ['title', 'description', 'country_id', 'start_date', 'end_date', 'category_id', 'max_mates', 'gender_preference', 'accommodation', 'image'],
            self::ACTIVE => ['description', 'max_mates', 'accommodation', 'image'],
            default => [],
        };
    }
}
