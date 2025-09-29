<?php

declare(strict_types=1);

namespace App\Actions\Trip;

use App\Enums\TripMateStatusEnum;
use App\Models\Trip;
use App\Models\TripMate;
use App\Models\User;
use App\Services\TripMateStatusMessage;
use DomainException;

final class JoinTripMateAction
{
    public function handle(Trip $trip, User $user): string
    {
        $mate = TripMate::firstOrCreate([
            'trip_id' => $trip->id,
            'user_id' => $user->id,

        ]);

        $from = $mate->exists ? $mate->status : null;

        if (in_array($mate->status, [TripMateStatusEnum::PENDING, TripMateStatusEnum::APPROVED], true)) {
            throw new DomainException('You already joined or have a pending request.');
        }

        $mate->status = TripMateStatusEnum::PENDING;
        $mate->save();

        return TripMateStatusMessage::forUser($from, TripMateStatusEnum::PENDING);
    }
}
