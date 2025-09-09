<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\Trip;

final class UpdateTripRequest extends StoreTripRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = parent::rules();

        foreach ($rules as &$rule) {
            $rule = array_map(fn ($r) => $r === 'required' ? 'sometimes' : $r, $rule);
        }

        return $rules;
    }
}
