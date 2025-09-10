<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\Trip;

use App\Enums\TripAccommodationEnum;
use App\Enums\UserGenderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateTripRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'country_id' => ['sometimes', 'exists:countries,id'],
            'image' => ['sometimes', 'file', 'mimes:png,jpg', 'max:2048'],
            'title' => ['sometimes', 'string', 'min:10', 'max:150'],
            'description' => ['sometimes', 'string', 'min:100'],
            'start_date' => ['sometimes', 'date', 'after_or_equal:today'],
            'end_date' => ['sometimes', 'date', 'after_or_equal:stard_date'],
            'publish' => ['boolean'],
            'category_id' => ['sometimes', 'exists:categories,id'],
            'languages' => ['array', 'sometimes'],
            'languages.*' => ['sometimes', 'integer', 'exists:languages,id'],
            'max_mates' => ['sometimes', 'integer'],
            'gender_preference' => ['sometimes', Rule::in(UserGenderEnum::values())],
            'accommodation' => ['sometimes', Rule::in(TripAccommodationEnum::values())],
        ];
    }
}
