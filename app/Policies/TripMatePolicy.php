<?php

namespace App\Policies;

use App\Enums\TripMateStatusEnum;
use App\Enums\TripStatusEnum;
use App\Models\Trip;
use App\Models\TripMate;
use App\Models\User;

class TripMatePolicy
{
    public function join(User $user, Trip $trip)
    {
        return $trip->status === TripStatusEnum::ACTIVE
            && !$trip->mates()->where('user_id', $user->id)->exists()
            && $trip->mates()->where('status', TripMateStatusEnum::APPROVED)->count() < $trip->max_mates;
    }

    public function cancel(User $user, TripMate $mate): bool
    {
        $mate->loadMissing('trip');
        return $mate->user_id === $user->id
            && $mate->status === TripMateStatusEnum::PENDING;
    }
    public function remove(User $user, TripMate $mate): bool
    {
        $mate->loadMissing('trip');
        return $mate->user_id === $user->id
            && $mate->status === TripMateStatusEnum::APPROVED;
    }
    public function approve(User $user, TripMate $mate): bool
    {
        $mate->loadMissing('trip');
        $trip = $mate->trip;

        return $trip->creator_id === $user->id
            && $mate->status === TripMateStatusEnum::PENDING
            && $trip->mates()->where('status', TripMateStatusEnum::APPROVED)->count() < $mate->trip->max_mates;
    }
    public function reject(User $user, TripMate $mate): bool
    {
        $mate->loadMissing('trip');
        return $mate->trip->creator_id === $user->id
            && $mate->status === TripMateStatusEnum::PENDING;
    }
    public function kick(User $user, TripMate $mate): bool
    {
        $mate->loadMissing('trip');
        return $mate->trip->creator_id === $user->id
            && $mate->status === TripMateStatusEnum::APPROVED;
    }
}
