<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\UserRoleEnum;
use App\Http\Requests\Auth\RegisterUserRequest;

final class UserDTO
{
    public function __construct(
        public string $email,
        public string $username,
        public UserRoleEnum $role,
        public string $password,
    ) {}

    public static function fromRequest(RegisterUserRequest $request): self
    {

        $data = $request->validated();

        return new self(
            email: $data['email'],
            username: $data['username'],
            role: UserRoleEnum::from($data['role']),
            password: $data['password']
        );
    }
}
