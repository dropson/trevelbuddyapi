<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\V1\Trip;

use App\Actions\Trip\JoinTripMateAction;
use App\Actions\Trip\UpdateTripMateStatusAction;
use App\Enums\TripMateStatusEnum;
use App\Http\Controllers\ApiController;
use App\Models\Trip;
use App\Models\TripMate;
use Illuminate\Http\Request;

final class TripMatePublicController extends ApiController
{
    public function join(Request $request, Trip $trip, JoinTripMateAction $action): \Illuminate\Http\JsonResponse
    {
        $this->authorize('join', [TripMate::class, $trip]);

        $message = $action->handle($trip, $request->user());

        return $this->ok($message);
    }

    public function leave(Request $request, Trip $trip, TripMate $mate, UpdateTripMateStatusAction $action): \Illuminate\Http\JsonResponse
    {
        $this->authorize('remove', $mate);

        [$mate, $message] = $action->handle($mate, TripMateStatusEnum::REMOVED, $request->user());

        return $this->ok($message);

    }
}
