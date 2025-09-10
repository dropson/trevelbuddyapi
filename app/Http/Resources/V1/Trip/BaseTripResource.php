<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Trip;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class BaseTripResource extends JsonResource
{
    protected function baseData(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'country' => [
                'id' => $this->country->id,
                'name' => $this->country->name,
            ],
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
            ],
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status->label(),
        ];
    }

    protected function allowedActions(User $user): array
    {
        return [

            'publish' => $user->can('publish', $this->resource),
            'cancel' => $user?->can('cancel', $this->resource),
            'approve' => $user?->can('approve', $this->resource),
            'reject' => $user?->can('reject', $this->resource),
            'edit' => $user?->can('update', $this->resource),
            'delete' => $user?->can('delete', $this->resource),
        ];
    }
}
