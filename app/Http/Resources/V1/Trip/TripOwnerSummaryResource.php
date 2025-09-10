<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Trip;

use Illuminate\Http\Request;

final class TripOwnerSummaryResource extends BaseTripResource
{
    public function toArray(Request $request): array
    {
        $user = $request->user();

        return array_merge($this->baseData(), [
            'allowed_actions' => $this->allowedActions($user),
            'allowed_transitions' => $this->allowedTransitionsFor($user),
        ]);
    }
}
