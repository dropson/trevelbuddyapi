<?php

declare(strict_types=1);

namespace App\Actions\Trip;

use App\DTOs\TripUpdateDTO;
use App\Enums\TripStatusEnum;
use App\Models\Trip;
use App\Services\TripStatusMessage;
use Illuminate\Support\Str;

final class UpdateTripAction
{
    private array $editableWhenActive = [
        'description',
        'max_mates',
        'publish',
        'accommodation',
        'image',
    ];

    public function handle(TripUpdateDTO $dto, Trip $trip): array
    {

        $oldStatus = $trip->status;
        $updates = $dto->toArray();
        $newStatus = $oldStatus;
        if ($trip->status === TripStatusEnum::REJECTED) {
            $newStatus = $dto->publish === true ? TripStatusEnum::PENDING : TripStatusEnum::DRAFT;
        }

        if ($oldStatus === TripStatusEnum::ACTIVE) {
            $changed = array_keys(array_diff_assoc(
                $updates,
                $trip->only(array_keys($updates))
            ));
            $notAllowed = array_diff($changed, $this->editableWhenActive);
            if ($notAllowed !== []) {
                $newStatus = TripStatusEnum::PENDING;
            }
        }

        if (in_array($oldStatus, [TripStatusEnum::DRAFT, TripStatusEnum::PENDING], true)) {
            $newStatus = $dto->publish === true ? TripStatusEnum::PENDING : TripStatusEnum::DRAFT;
        }

        $trip->fill($updates);
        $trip->status = $newStatus;

        if ($dto->image instanceof \Illuminate\Http\UploadedFile) {
            $filename = time().'_'.Str::random(6).'.'.$dto->image->getClientOriginalExtension();
            $path = $dto->image->storeAs('trips', $filename, 'public');
            $trip->image_path = $path;
        }

        $trip->save();

        if ($dto->languages !== null) {
            $trip->languages()->sync($dto->languages);
        }
        $message = TripStatusMessage::forUser($oldStatus, $newStatus);

        return [$trip->fresh(['country', 'creator', 'languages']), $message];
    }
}
