<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TripAccommodationEnum;
use App\Enums\TripStatusEnum;
use App\Enums\UserGenderEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

final class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'creator_id',
        'country_id',
        'image_path',
        'title',
        'slug',
        'description',
        'start_date',
        'end_date',
        'status',
        'category_id',
        'max_mates',
        'gender_preference',
        'accommodation',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'trip_language');
    }

    public function scopeStatus(Builder $q, ?string $status): Builder
    {
        return $status !== null && $status !== '' && $status !== '0' ? $q->where('status', $q) : $q;
    }

    public function getImageUrlAttribute(): string
    {
        return Storage::disk('public')->url($this->image_path);
    }

    public function allowedTransitions(): array
    {
        return array_map(fn (TripStatusEnum $s) => $s->value, $this->status->transitions());
    }

    public function getCreatedAtAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getStartDateAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getEndDateAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    protected function casts(): array
    {
        return [
            'status' => TripStatusEnum::class,
            'start_date' => 'date:Y-m-d',
            'end_date' => 'date:Y-m-d',
            'gender_preference' => UserGenderEnum::class,
            'accommodation' => TripAccommodationEnum::class,
        ];
    }
}
