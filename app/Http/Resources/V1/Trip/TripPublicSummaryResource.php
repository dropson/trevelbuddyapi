<?php

namespace App\Http\Resources\V1\Trip;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TripPublicSummaryResource extends BaseTripResource
{

    public function toArray(Request $request): array
    {
        $user = $request->user();

        return array_merge($this->baseData(), [
            'creator' => [
                'id' => $this->creator->id,
                'name' => $this->creator->name,
            ]
        ]);
    }
}
