<?php

declare(strict_types=1);

namespace App\Actions\Trip;

use App\DTOs\TripDTO;
use App\Enums\TripStatusEnum;
use App\Models\Trip;
use Illuminate\Support\Str;

final class UpdateTripAction
{
    private array $editableFields = [
        'description',
        'max_mates',
        'languages',
        'accommodation',
    ];

    private array $sensitiveFields = [
        'title',
        'description',
        'start_date',
        'end_date',
        'country_id',
        'category_id',
        'gender_preference',
        'image',
    ];

    public function handle(TripDTO $dto, Trip $trip)
    {

        $newStatus = $trip->status;
        if ($trip->status === TripStatusEnum::REJECTED) {
            $newStatus = $dto->publish
                ? TripStatusEnum::PENDING->value
                : TripStatusEnum::DRAFT->value;
        }
        if ($trip->status === TripStatusEnum::ACTIVE) {
            $dirty = [];

            foreach ($this->editableFields as $field) {
                if ($trip->$field !== $dto->$field) {
                    $dirty[] = $field;
                }
            }

            foreach ($this->sensitiveFields as $field) {
                if ($trip->$field !== $dto->$field) {
                    $dirty[] = $field;
                    $newStatus = TripStatusEnum::PENDING;
                }
            }

            if ($newStatus === $trip->status) {
                $newStatus = TripStatusEnum::ACTIVE;
            }
        }
        if (in_array($trip->status, [TripStatusEnum::DRAFT, TripStatusEnum::PENDING])) {
            $newStatus = $dto->publish
                ? TripStatusEnum::PENDING
                : TripStatusEnum::DRAFT;
        }

        $trip->fill([
            'country_id' => $dto->country_id,
            'title' => $dto->title,
            'description' => $dto->description,
            'start_date' => $dto->start_date,
            'end_date' => $dto->end_date,
            'status' => $newStatus,
            'category_id' => $dto->category_id,
            'max_mates' => $dto->max_mates,
            'gender_preference' => $dto->gender_preference,
            'accommodation' => $dto->accommodation,
        ]);
        if ($dto->image instanceof \Illuminate\Http\UploadedFile) {
            $filename = time().'_'.Str::random(6).'.'.$dto->image->getClientOriginalExtension();
            $path = $dto->image->storeAs('trips', $filename, 'public');
            $trip->image_path = $path;
        }

        $trip->save();

        $trip->languages()->sync($dto->languages);

        return $trip->fresh(['country', 'creator', 'languages']);
    }
}
