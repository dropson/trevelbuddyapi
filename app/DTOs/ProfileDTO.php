<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\UserGenderEnum;
use App\Http\Requests\V1\ProfileUploadRequest;

// use Illuminate\Support\Facades\Date;

final class ProfileDTO
{
    public function __construct(
        public ?string $fullname,
        public ?string $birthdate,
        public ?UserGenderEnum $gender,
        public ?int $country,
        public ?string $city,
        public ?array $languages,
        public ?array $interests,
        public ?array $visited_countries,
        public ?string $bio,
        public ?string $description,
    ) {}

    public static function fromRequest(ProfileUploadRequest $request): self
    {
        $data = $request->validated();

        return new self(
            fullname: $data['full_name'] ?? null,
            birthdate: $data['birth_date'] ?? null,
            gender: isset($data['gender']) ? UserGenderEnum::from($data['gender']) : null,
            country: $data['country'] ?? null,
            city: $data['city'] ?? null,
            languages: $data['languages'] ?? null,
            interests: $data['interests'] ?? null,
            visited_countries: $data['visited_countries'] ?? null,
            bio: $data['bio'] ?? null,
            description: $data['description'] ?? null,
        );
    }
}
