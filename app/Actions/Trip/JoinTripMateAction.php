<?php

declare(strict_types=1);

namespace App\Actions\Trip;

use App\Enums\TripMateStatusEnum;
use App\Models\Trip;
use App\Models\TripMate;
use App\Models\User;
use App\Services\TripMateStatusMessage;

final class JoinTripMateAction
{
    public function handle(Trip $trip, User $user)
    {
        TripMate::create([
            'trip_id' => $trip->id,
            'user_id' => $user->id,
            'status' => TripMateStatusEnum::PENDING,
        ]);

        return TripMateStatusMessage::forUser(null, TripMateStatusEnum::PENDING);
    }
}
