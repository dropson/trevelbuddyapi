<?php

declare(strict_types=1);

namespace App\Filters;

use App\Enums\TripAccommodationEnum;
use App\Enums\UserGenderEnum;
use Illuminate\Database\Eloquent\Builder;

final class TripFilter extends QueryFilter
{
    public function country(int $id): Builder
    {
        return $this->builder->where('country_id', $id);
    }

    public function category(int $id): Builder
    {
        return $this->builder->where('category_id', $id);
    }

    public function gender(string $value): Builder
    {
        return $this->builder->where('gender_preference', UserGenderEnum::from($value));
    }

    public function accommodation(string $value): Builder
    {
        return $this->builder->where('accommodation', TripAccommodationEnum::from($value));
    }

    public function languages(string $langs): Builder
    {
        $langs = explode(',', $langs);

        return $this->builder->whereHas('languages', function ($q) use ($langs): void {
            $q->whereIn('languages.id', $langs);
        });
    }
}
