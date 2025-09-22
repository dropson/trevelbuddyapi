<?php

namespace App\Actions\Trip;

use App\Enums\TripMateStatusEnum;
use App\Models\TripMate;
use App\Services\TripMateStatusMessage;
use DomainException;

class UpdateTripMateStatusAction
{
    public function handle(TripMate $mate, TripMateStatusEnum $to,  $user)
    {
        $from = $mate->status;

        $allowed = $mate->allowedTransitionsFor($user, $mate->trip);

        if (!in_array($to->value, $allowed, true)) {
            throw new DomainException("Transition {$from->value} -> {$to->value} is not allowed");
        }
        $mate->update(['status' => $to]);

        $message = $user->id === $mate->trip->creator_id
            ? TripMateStatusMessage::forOwner($from, $to)
            : TripMateStatusMessage::forUser($from, $to);

        return [$mate, $message];
    }
}
