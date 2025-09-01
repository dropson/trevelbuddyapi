<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\DTOs\UserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class RegisterUserAction
{
    public function handle(UserDTO $data)
    {
        $user = User::create([
            'username' => $data->username,
            'email' => $data->email,
            'password' => Hash::make($data->password),
        ]);
        $user->profile()->create();
        $user->assignRole($data->role);

        return $user;
    }
}
