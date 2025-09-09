<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\V1\Trip;

use App\Actions\Trip\CreateTripAction;
use App\Actions\Trip\UpdateTripAction;
use App\DTOs\TripDTO;
use App\Http\Controllers\ApiController;
use App\Http\Requests\V1\Trip\StoreTripRequest;
use App\Http\Requests\V1\Trip\UpdateTripRequest;
use App\Http\Resources\V1\TripResource;
use App\Models\Trip;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

final class MyTripController extends ApiController
{
    public function store(StoreTripRequest $request, CreateTripAction $action): JsonResponse
    {
        $trip = $action->handle(TripDTO::fromRequest($request), $request->user());

        return $this->success($trip->status->successMessage(), new TripResource($trip));
    }

    public function show(Trip $trip): TripResource
    {
        return new TripResource($trip->load('category'));
    }

    public function update(UpdateTripRequest $request, Trip $trip, UpdateTripAction $action): JsonResponse
    {
        $this->authorize('update', $trip);
        $trip = $action->handle(TripDTO::fromRequest($request), $trip);

        return $this->success($trip->status->successMessage(), new TripResource($trip));
    }

    public function destroy(Trip $trip): JsonResponse
    {
        $this->authorize('delete', $trip);
        if ($trip->image_path) {
            Storage::delete($trip->image_path);
        }
        $trip->delete();

        // TODO members
        return $this->ok('Trip successfully deleted');
    }
}
