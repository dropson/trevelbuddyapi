<?php

namespace App\Actions\Trip;

use App\Enums\TripMateStatusEnum;
use App\Enums\TripStatusEnum;
use App\Models\Trip;
use App\Models\TripMate;
use App\Models\User;
use App\Services\TripMateStatusMessage;

class JoinTripMateAction
{
    public function handle(Trip $trip, User $user)
    {
        $mate = TripMate::create([
            'trip_id' => $trip->id,
            'user_id' => $user->id,
            'status' => TripMateStatusEnum::PENDING
        ]);

        $message = TripMateStatusMessage::forUser(null , TripMateStatusEnum::PENDING);

        return $message;
    }
}
