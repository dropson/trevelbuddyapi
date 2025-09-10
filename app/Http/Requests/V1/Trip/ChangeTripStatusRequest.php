<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\Trip;

use App\Enums\TripStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class ChangeTripStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(TripStatusEnum::values())],
            'cancel_reason' => ['required_if:status,rejected', 'string'],
        ];
    }
}
