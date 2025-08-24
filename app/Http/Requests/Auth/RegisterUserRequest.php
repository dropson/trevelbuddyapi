<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use App\Enums\UserRoleEnum;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

final class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class,  Rule::anyOf([
                ['string', 'email'],
                ['string', 'alpha_dash', 'min:5'],
            ]), ],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role' => ['required', Rule::in(UserRoleEnum::values())],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }
}
