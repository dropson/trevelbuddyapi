<?php

declare(strict_types=1);

namespace App\Enums;

enum TripMateStatusEnum: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case CANCELLED = 'cancelled';
    case REMOVED = 'removed';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function userTransitions(): array
    {
        return match ($this) {
            self::REJECTED, self::REMOVED => [self::PENDING],
            self::PENDING => [self::CANCELLED],
            self::APPROVED => [self::REMOVED],
            default => []
        };
    }

    public function ownerTransitions(): array
    {
        return match ($this) {
            self::PENDING => [self::APPROVED, self::REJECTED],
            self::APPROVED => [self::REMOVED],
            default => []
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::APPROVED => 'Approved',
            self::REJECTED => 'Rejected',
        };
    }
}
