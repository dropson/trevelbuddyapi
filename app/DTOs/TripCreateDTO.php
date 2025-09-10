<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\TripAccommodationEnum;
use App\Enums\UserGenderEnum;
use App\Http\Requests\V1\Trip\StoreTripRequest;
use App\Http\Requests\V1\Trip\UpdateTripRequest;
use Illuminate\Http\UploadedFile;

final class TripCreateDTO
{
    public function __construct(
        public int $country_id,
        public ?UploadedFile $image,
        public string $title,
        public string $description,
        public string $start_date,
        public string $end_date,
        public bool $publish,
        public int $category_id,
        public array $languages,
        public int $max_mates,
        public UserGenderEnum $gender_preference,
        public TripAccommodationEnum $accommodation
    ) {}

    public static function fromRequest(StoreTripRequest|UpdateTripRequest $request): self
    {
        $data = $request->validated();

        return new self(
            country_id: $data['country_id'],
            image: $data['image'] ?? null,
            title: $data['title'],
            description: $data['description'],
            start_date: $data['start_date'],
            end_date: $data['end_date'],
            publish: $data['publish'],
            category_id: $data['category_id'],
            languages: $data['languages'],
            max_mates: $data['max_mates'],
            gender_preference: UserGenderEnum::from($data['gender_preference']),
            accommodation: TripAccommodationEnum::from($data['accommodation']),
        );
    }
}
