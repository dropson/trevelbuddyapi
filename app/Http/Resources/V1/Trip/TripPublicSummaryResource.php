<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Trip;

use App\Http\Resources\V1\LanguageResource;
use Illuminate\Http\Request;

final class TripPublicSummaryResource extends BaseTripResource
{
    public function toArray(Request $request): array
    {
        $request->user();

        return array_merge($this->baseData(), [
            'creator' => [
                'id' => $this->creator->id,
                'name' => $this->creator->name,
            ],
            'languages' => LanguageResource::collection($this->languages),
            'gender_preference' => $this->gender_preference,
        ]);
    }
}
