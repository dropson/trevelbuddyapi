<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\TripMateStatusEnum;
use App\Enums\TripStatusEnum;
use App\Models\Trip;
use App\Models\User;

final class TripPolicy
{

    public function viewMates(User $user, Trip $trip): bool
    {
        return $user->id === $trip->creator_id;
    }
    public function publish(User $user, Trip $trip): bool
    {
        return $user->id === $trip->creator_id && in_array($trip->status, [TripStatusEnum::DRAFT, TripStatusEnum::REJECTED], true);
    }

    public function cancel(User $user, Trip $trip): bool
    {
        return $user->id === $trip->creator_id && in_array($trip->status, [TripStatusEnum::PENDING, TripStatusEnum::ACTIVE], true);
    }

    public function approve(User $user, Trip $trip): bool
    {
        return $user->hasRole('moderator') && $trip->status === TripStatusEnum::PENDING;
    }

    public function reject(User $user, Trip $trip): bool
    {
        return $user->hasRole('moderator') && $trip->status === TripStatusEnum::PENDING;
    }

    public function update(User $user, Trip $trip): bool
    {

        return $user->id === $trip->creator_id
            && in_array($trip->status, [TripStatusEnum::DRAFT, TripStatusEnum::ACTIVE, TripStatusEnum::REJECTED], true);
    }

    public function delete(User $user, Trip $trip): bool
    {
        return ($user->id === $trip->creator_id)
            || $user->hasRole('moderator');
    }

}
