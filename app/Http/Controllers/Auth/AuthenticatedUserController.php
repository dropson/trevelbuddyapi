<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Resources\V1\UserResource;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

final class AuthenticatedUserController extends Controller
{
    use ApiResponses;

    public function store(LoginUserRequest $request): JsonResponse
    {
        $credentials = $request->validated();

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return $this->error('Invalid credentials', 401);
        }

        return $this->ok(
            'Authenticated',
            [
                'token' => $user->createToken('auth-token')->plainTextToken,
                'user' => new UserResource($user->load('profile')),
            ]
        );
    }

    public function destroy(Request $request): JsonResponse
    {
        if ($request->user()) {
            $request->user()->currentAccessToken()->delete();
        }

        return $this->ok('Logged out sucessfully');
    }
}
