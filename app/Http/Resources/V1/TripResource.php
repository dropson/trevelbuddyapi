<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Enums\TripStatusEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class TripResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $user = $request->user();

        $alloweActions = [

            'publish' => $user->can('publish', $this->resource),
            'cancel' => $user?->can('cancel', $this->resource),
            'approve' => $user?->can('approve', $this->resource),
            'reject' => $user?->can('reject', $this->resource),
            'edit' => $user?->can('update', $this->resource),
            'delete' => $user?->can('delete', $this->resource),
        ];

        $editableFields = match ($this->status) {
            TripStatusEnum::DRAFT, TripStatusEnum::REJECTED => ['title', 'description', 'country_id', 'start_date', 'end_date', 'category_id', 'max_mates', 'gender_preference', 'accommodation', 'image'],
            TripStatusEnum::PENDING => [],
            TripStatusEnum::ACTIVE => ['description', 'max_mates', 'accommodation', 'image'],
            default => [],
        };

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'country' => [
                'id' => $this->country->id,
                'name' => $this->country->name,
            ],
            'creator' => [
                'id' => $this->creator->id,
                'name' => $this->creator->name,
            ],
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
            ],
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'max_mates' => $this->max_mates,
            'status' => $this->status,
            'gender_preference' => $this->gender_preference,
            'accommodation' => $this->accommodation,
            'created_at' => $this->created_at,
            'cancel_reason' => $this->cancel_reason,
            'editable_fields' => $editableFields,
            'allowed_actions' => $alloweActions,
            'allowed_transitions' => $this->allowedTransitions(),
        ];
    }
}
