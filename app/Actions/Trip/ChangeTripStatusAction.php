<?php

declare(strict_types=1);

namespace App\Actions\Trip;

use App\Enums\TripStatusEnum;
use App\Models\Trip;
use App\Models\User;
use DomainException;

final class ChangeTripStatusAction
{
    public function handle(Trip $trip, User $user, array $data): Trip
    {
        if (! in_array($data['status'], $trip->allowedTransitionsFor($user))) {
            throw new DomainException("Invalid status transition from {$trip->status->value} to {$data['status']->value}");
        }

        $trip->update(
            [
                'status' => $data['status'],
                'cancel_reason' => $data['cancel_reason'] ?? null,
            ]
        );
        if (in_array($data['status'], [TripStatusEnum::ACTIVE, TripStatusEnum::REJECTED])) {
            // $trip->creator->notify(new TripStatusChanged($trip, $newStatus, $user));
            // TODO event
        }

        return $trip->fresh();
    }
}
