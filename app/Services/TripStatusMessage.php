<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\TripStatusEnum;

final class TripStatusMessage
{
    public static function forUser(TripStatusEnum $from, TripStatusEnum $to): string
    {
        return match ([$from, $to]) {
            [TripStatusEnum::DRAFT, TripStatusEnum::DRAFT] => 'Trip saved as draft.',
            [TripStatusEnum::DRAFT, TripStatusEnum::PENDING] => 'Trip submitted for moderation.',
            [TripStatusEnum::ACTIVE, TripStatusEnum::PENDING] => 'Trip resubmited for moderation.',
            [TripStatusEnum::REJECTED, TripStatusEnum::PENDING] => 'Trip resubmited for moderation.',
            [TripStatusEnum::REJECTED, TripStatusEnum::DRAFT] => 'Trip saved as draft again.',
            [TripStatusEnum::PENDING, TripStatusEnum::DRAFT] => 'Trip cancelled and moved to draft.',
            default => 'Trip updated successfully.',
        };
    }

    public static function forModerator(TripStatusEnum $from, TripStatusEnum $to): string
    {
        return match ([$from, $to]) {
            [TripStatusEnum::PENDING, TripStatusEnum::ACTIVE] => 'Trip approved and is now active.',
            [TripStatusEnum::PENDING, TripStatusEnum::REJECTED] => 'Trip has been rejected.',
            default => 'Trip status updated.',
        };
    }
}
