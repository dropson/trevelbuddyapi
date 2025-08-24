<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\ApiController;
use App\Http\Resources\V1\UserResource;
use Illuminate\Http\Request;

final class ProfileController extends ApiController
{
    public function show(Request $request): UserResource
    {
        return new UserResource($request->user());
    }
}
