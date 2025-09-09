<?php

declare(strict_types=1);

namespace App\Enums;

enum TripStatusEnum: string
{
    case DRAFT = 'Draft';
    case PENDING = 'Pending';
    case ACTIVE = 'Active';
    case REJECTED = 'Rejected';
    case COMPLETED = 'Completed';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function transitions(): array
    {
        return match ($this) {
            self::DRAFT => [self::PENDING],
            self::PENDING => [self::ACTIVE, self::REJECTED, self::DRAFT],
            self::ACTIVE => [self::COMPLETED, self::DRAFT],
            self::REJECTED, => [self::PENDING],
            self::COMPLETED => []
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::PENDING => 'Pending moderation',
            self::ACTIVE => 'Active',
            self::REJECTED => 'Rejected',
            self::COMPLETED => 'Completed',
        };
    }

    public function successMessage(): string
    {
        return match ($this) {
            self::DRAFT => 'Trip saved as Draft',
            self::PENDING => 'Trip sent for moderation',
            self::ACTIVE => 'Trip approved and is now Active',
            self::REJECTED => 'Trip was rejected',
            self::COMPLETED => 'Trip marked as Completed',
        };
    }
}
