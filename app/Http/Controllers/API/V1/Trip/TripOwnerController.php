<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\V1\Trip;

use App\Actions\Trip\CreateTripAction;
use App\Actions\Trip\UpdateTripAction;
use App\DTOs\TripCreateDTO;
use App\DTOs\TripUpdateDTO;
use App\Http\Controllers\ApiController;
use App\Http\Requests\V1\Trip\StoreTripRequest;
use App\Http\Requests\V1\Trip\UpdateTripRequest;
use App\Http\Resources\V1\Trip\TripOwnerResource;
use App\Http\Resources\V1\Trip\TripOwnerSummaryResource;
use App\Models\Trip;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

final class TripOwnerController extends ApiController
{
    public function index(Request $request)
    {
        $trips = $request->user()->trips->load('country', 'creator', 'category');

        return TripOwnerSummaryResource::collection($trips);
    }

    public function store(StoreTripRequest $request, CreateTripAction $action): JsonResponse
    {
        [$trip, $message] = $action->handle(TripCreateDTO::fromRequest($request), $request->user());

        return $this->success($message, new TripOwnerResource($trip));
    }

    public function show(Trip $trip): TripOwnerResource
    {
        return new TripOwnerResource($trip->load('category'));
    }

    public function update(UpdateTripRequest $request, Trip $trip, UpdateTripAction $action): JsonResponse
    {
        $this->authorize('update', $trip);
        [$trip, $message] = $action->handle(TripUpdateDTO::fromRequest($request), $trip);

        return $this->success($message, new TripOwnerResource($trip));
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
