<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TripMateStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class TripMate extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id',
        'user_id',
        'status'
    ];

    protected $casts = [
        'status' => TripMateStatusEnum::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }
    public function allowedTransitionsFor(User $user, Trip $trip): array
    {
        if ($user->id === $trip->creator_id) {
            return array_map(fn(TripMateStatusEnum $s) => $s->value, $this->status->ownerTransitions());
        }

        return array_map(fn(TripMateStatusEnum $s) => $s->value, $this->status->userTransitions());
    }
}
