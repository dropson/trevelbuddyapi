<?php

declare(strict_types=1);

namespace App\Http\Requests\V1;

use App\Enums\UserGenderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class ProfileUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', Rule::in(UserGenderEnum::values())],
            'birth_date' => ['nullable', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'languages' => ['array'],
            'languages.*' => ['integer', 'exists:languages,id'],
            'interests' => ['array'],
            'interests.*' => ['integer', 'exists:interests,id'],
            'visited_countries' => ['nullable', 'array'],
            'bio' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
        ];
    }
}
