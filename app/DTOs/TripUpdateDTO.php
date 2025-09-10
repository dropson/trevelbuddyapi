<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\TripAccommodationEnum;
use App\Enums\UserGenderEnum;
use App\Http\Requests\V1\Trip\UpdateTripRequest;
use Illuminate\Http\UploadedFile;

final class TripUpdateDTO
{
    public function __construct(
        public ?int $country_id,
        public ?UploadedFile $image,
        public ?string $title,
        public ?string $description,
        public ?string $start_date,
        public ?string $end_date,
        public ?bool $publish,
        public ?int $category_id,
        public ?array $languages,
        public ?int $max_mates,
        public ?UserGenderEnum $gender_preference,
        public ?TripAccommodationEnum $accommodation
    ) {}

    public static function fromRequest(UpdateTripRequest $request): self
    {
        $data = $request->validated();

        return new self(
            country_id: $data['country_id'] ?? null,
            image: $data['image'] ?? null,
            title: $data['title'] ?? null,
            description: $data['description'] ?? null,
            start_date: $data['start_date'] ?? null,
            end_date: $data['end_date'] ?? null,
            publish: $data['publish'],
            category_id: $data['category_id'] ?? null,
            languages: $data['languages'] ?? null,
            max_mates: $data['max_mates'] ?? null,
            gender_preference: isset($data['gender_preference']) ? UserGenderEnum::from($data['gender_preference']) : null,
            accommodation: isset($data['accommodation']) ? TripAccommodationEnum::from($data['accommodation']) : null,
        );
    }

    public function toArray(): array
    {
        return array_filter(get_object_vars($this), fn ($v): bool => $v !== null);
    }
}
