<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Trip;

use App\Enums\TripMateStatusEnum;
use App\Models\TripMate;
use Illuminate\Http\Request;

final class TripPublicResource extends BaseTripResource
{
    public function toArray(Request $request): array
    {
        $user = $request->user();
        $mate = $this->mates()->where('user_id', $user->id)->first();

        return array_merge($this->baseData(), [
            'creator' => [
                'id' => $this->creator->id,
                'name' => $this->creator->name,
            ],
            'description' => $this->description,
            'accommodation' => $this->accommodation,
            'max_mates' => $this->max_mates,
            'mates' => TripMatePublicResource::collection($this->mates->where('status', TripMateStatusEnum::APPROVED)),

            'allowed_actions' => $user ? [
                'join' => $user->can('join', [TripMate::class, $this->resource]),
                'cancel' => $mate ? $user->can('cancel', $mate) : false,
                'remove' => $mate ? $user->can('remove', $mate) : false,
            ] : [],
        ]);
    }
}
