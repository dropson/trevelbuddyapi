<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\Trip;

use App\Enums\TripAccommodationEnum;
use App\Enums\UserGenderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreTripRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'country_id' => ['required', 'exists:countries,id'],
            'image' => ['sometimes', 'file', 'mimes:png,jpg', 'max:2048'],
            'title' => ['required', 'string', 'min:10', 'max:150'],
            'description' => ['required', 'string', 'min:100'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after_or_equal:stard_date'],
            'publish' => ['boolean'],
            'category_id' => ['required', 'exists:categories,id'],
            'languages' => ['array'],
            'languages.*' => ['integer', 'exists:languages,id'],
            'max_mates' => ['required', 'integer'],
            'gender_preference' => ['required', Rule::in(UserGenderEnum::values())],
            'accommodation' => ['required', Rule::in(TripAccommodationEnum::values())],
        ];
    }
}
