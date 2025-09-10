<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Trip;

use Illuminate\Http\Request;

final class TripPublicResource extends BaseTripResource
{
    public function toArray(Request $request): array
    {
        $request->user();

        return array_merge($this->baseData(), [
            'aa' => 'bbb',
        ]);
    }
}
