<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\V1\Trip;

use App\Enums\TripStatusEnum;
use App\Http\Controllers\ApiController;
use App\Http\Resources\V1\Trip\TripPublicResource;
use App\Http\Resources\V1\Trip\TripPublicSummaryResource;
use App\Models\Trip;

final class TripPublicController extends ApiController
{
    public function index()
    {
        $trips = Trip::status(TripStatusEnum::ACTIVE->value)->with(['country', 'category', 'creator'])->paginate(20);

        return TripPublicSummaryResource::collection($trips);
    }
    public function show(Trip $trip): TripPublicResource
    {
        abort_unless($trip->status === TripStatusEnum::ACTIVE, 404);
        return new TripPublicResource($trip->load('mates.user.profile'));
    }
}
