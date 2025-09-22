<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Trip;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class TripMateOwnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $request->user();

        return [
            'id' => $this->id,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->profile->full_name ?? $this->user->username,
            ],
            'status' => $this->status->value,

            'allowed_actions' => [
                'approve' => $user->can('approve', $this->resource),
                'reject' => $user->can('reject', $this->resource),
                'kick' => $user->can('kick', $this->resource),
            ],
        ];
    }
}
