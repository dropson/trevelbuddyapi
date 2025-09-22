<?php

namespace App\Services;

use App\Enums\TripMateStatusEnum;

class TripMateStatusMessage
{
    public static function forUser(?TripMateStatusEnum $fromm, TripMateStatusEnum $to)
    {
        return match ([$fromm, $to]){
            [null, TripMateStatusEnum::PENDING] => 'Request to join the trip has been sent',
            [TripMateStatusEnum::REJECTED, TripMateStatusEnum::PENDING] => 'Request to join trip sent again',
            [TripMateStatusEnum::APPROVED, TripMateStatusEnum::REMOVED] => 'You’ve left the trip',
            [TripMateStatusEnum::PENDING, TripMateStatusEnum::CANCELLED] => 'You cancelled your request.',
        };
    }

    public static function forOwner(TripMateStatusEnum $fromm, TripMateStatusEnum $to)
    {
        return match ([$fromm, $to]){
            [TripMateStatusEnum::PENDING, TripMateStatusEnum::APPROVED] => 'User joined the trip',
            [TripMateStatusEnum::PENDING, TripMateStatusEnum::REJECTED] => 'Join request rejected',
            [TripMateStatusEnum::APPROVED, TripMateStatusEnum::REMOVED] => 'User removed from the trip',
        };
    }
}
