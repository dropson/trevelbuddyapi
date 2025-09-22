<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Trip;

use Illuminate\Http\Request;

final class TripOwnerResource extends BaseTripResource
{
    public function toArray(Request $request): array
    {
        $user = $request->user();

        return array_merge($this->baseData(), [
            'creator' => [
                'id' => $this->creator->id,
                'name' => $this->creator->name,
            ],
            'description' => $this->description,
            'max_mates' => $this->max_mates,
            'gender_preference' => $this->gender_preference,
            'accommodation' => $this->accommodation,
            'created_at' => $this->created_at,
            'cancel_reason' => $this->cancel_reason,
            'editable_fields' => $this->status->editableFields(),
            'allowed_actions' => $this->allowedActions($user),
            'allowed_transitions' => $this->allowedTransitionsFor($user),
        ]);
    }
}
