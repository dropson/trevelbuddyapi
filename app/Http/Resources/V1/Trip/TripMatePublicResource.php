<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Trip;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class TripMatePublicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->profile->full_name ?? $this->user->username,
                'avatar' => $this->user->profile->avatar_url ?? null,
            ],
            'status' => $this->status->label(),
        ];
    }
}
