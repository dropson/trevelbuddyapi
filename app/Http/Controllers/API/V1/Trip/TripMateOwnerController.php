<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\V1\Trip;

use App\Actions\Trip\UpdateTripMateStatusAction;
use App\Enums\TripMateStatusEnum;
use App\Http\Controllers\ApiController;
use App\Http\Resources\V1\Trip\TripMateOwnerResource;
use App\Models\Trip;
use App\Models\TripMate;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

final class TripMateOwnerController extends ApiController
{
    public function index(Request $request, Trip $trip)
    {
        $this->authorize('viewMates', $trip);

        $status = $request->query('status');
        $mates = $trip->mates()
            ->with('user.profile')
            ->when($status, fn ($q) => $q->where('status', $status))
            ->get();

        return TripMateOwnerResource::collection($mates);
    }

    public function updadeStatus(Request $request, Trip $trip, TripMate $mate, UpdateTripMateStatusAction $action): \Illuminate\Http\JsonResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(TripMateStatusEnum::values())],
        ]);
        $status = TripMateStatusEnum::from($data['status']);
        $this->authorize($this->mapAbility($status), $mate);
        [$mate, $message] = $action->handle($mate, $status, $request->user());

        return $this->success($message, new TripMateOwnerResource($mate));
    }

    private function mapAbility(TripMateStatusEnum $status): string
    {
        return match ($status) {
            TripMateStatusEnum::APPROVED => 'approve',
            TripMateStatusEnum::REJECTED => 'reject',
            TripMateStatusEnum::REMOVED => 'kick',
        };
    }
}
