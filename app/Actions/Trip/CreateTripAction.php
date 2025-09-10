<?php

declare(strict_types=1);

namespace App\Actions\Trip;

use App\DTOs\TripCreateDTO;
use App\Enums\TripStatusEnum;
use App\Models\Trip;
use App\Models\User;
use App\Services\TripStatusMessage;
use Illuminate\Support\Str;

final class CreateTripAction
{
    public function handle(TripCreateDTO $dto, User $creator): array
    {

        $status = $dto->publish
            ? TripStatusEnum::PENDING
            : TripStatusEnum::DRAFT;

        $message = TripStatusMessage::forUser(
            TripStatusEnum::DRAFT,
            $status
        );

        $trip = new Trip([
            'creator_id' => $creator->id,
            'country_id' => $dto->country_id,
            'title' => $dto->title,
            'description' => $dto->description,
            'start_date' => $dto->start_date,
            'end_date' => $dto->end_date,
            'status' => $status,
            'category_id' => $dto->category_id,
            'max_mates' => $dto->max_mates,
            'gender_preference' => $dto->gender_preference,
            'accommodation' => $dto->accommodation,
        ]);

        if ($dto->image instanceof \Illuminate\Http\UploadedFile) {
            $filename = time().'_'.Str::random(6).'.'.${$dto}->image->getClientOriginalExtension();
            $path = $dto->image->storeAs('trips', $filename, 'public');
            $trip->image_path = $path;
        }

        $trip->save();

        $trip->languages()->sync($dto->languages);

        return [$trip->fresh(['country', 'creator', 'languages']), $message];
    }
}
