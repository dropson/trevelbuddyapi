<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\Users\RegisterUserAction;
use App\DTOs\UserDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Traits\ApiResponses;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;

final class RegisterUserController extends Controller
{
    use ApiResponses;

    public function __invoke(RegisterUserRequest $request, RegisterUserAction $action): JsonResponse
    {
        $user = $action->handle(UserDTO::fromRequest($request));

        event(new Registered($user));

        return $this->success('Account created successfully. Please verify your email.', [], 201);
    }
}
