<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\V1\Trip;

use App\Actions\Trip\ChangeTripStatusAction;
use App\Enums\TripStatusEnum;
use App\Http\Controllers\ApiController;
use App\Http\Requests\V1\Trip\ChangeTripStatusRequest;
use App\Http\Resources\V1\TripResource;
use App\Models\Trip;
use Illuminate\Http\JsonResponse;

final class TripStatusController extends ApiController
{
    public function __invoke(ChangeTripStatusRequest $request, Trip $trip, ChangeTripStatusAction $action): JsonResponse
    {
        $data = $request->validated();
        $newStatus = TripStatusEnum::from($data['status']);
        match ($newStatus) {
            TripStatusEnum::ACTIVE => $this->authorize('approve', $trip),
            TripStatusEnum::REJECTED => $this->authorize('reject', $trip),
            TripStatusEnum::COMPLETED => $this->authorize('complete', $trip),
            TripStatusEnum::DRAFT => $this->authorize('cancel', $trip),
            TripStatusEnum::PENDING => $this->authorize('publish', $trip),
            default => $this->authorize('update', $trip),
        };

        $trip = $action->handle($trip, $request->user(), $data);

        return $this->success($newStatus->successMessage(), new TripResource($trip->fresh()));
    }
}
