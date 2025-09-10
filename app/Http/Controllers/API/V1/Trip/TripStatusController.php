<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\V1\Trip;

use App\Actions\Trip\ChangeTripStatusAction;
use App\Enums\TripStatusEnum;
use App\Http\Controllers\ApiController;
use App\Http\Requests\V1\Trip\ChangeTripStatusRequest;
use App\Http\Resources\V1\Trip\TripOwnerResource;
use App\Models\Trip;
use App\Services\TripStatusMessage;
use Illuminate\Http\JsonResponse;

final class TripStatusController extends ApiController
{
    public function __invoke(ChangeTripStatusRequest $request, Trip $trip, ChangeTripStatusAction $action): JsonResponse
    {
        $data = $request->validated();
        $newStatus = TripStatusEnum::from($data['status']);
        $oldStatus = $trip->status;

        match ($newStatus) {
            TripStatusEnum::ACTIVE => $this->authorize('approve', $trip),
            TripStatusEnum::REJECTED => $this->authorize('reject', $trip),
            default => $this->authorize('update', $trip),
        };

        $trip = $action->handle($trip, $request->user(), $data);

        $message = TripStatusMessage::forModerator($oldStatus, $newStatus);

        return $this->success($message, new TripOwnerResource($trip));
    }
}
