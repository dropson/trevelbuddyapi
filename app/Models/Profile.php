<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserGenderEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

final class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'avatar_path',
        'banner_path',
        'birth_date',
        'gender',
        'location',
        'visited_countries',
        'bio',
        'description',
    ];

    protected $appends = ['avatar_url', 'banner_url', 'birth_date'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'profile_language');
    }

    public function interests(): BelongsToMany
    {
        return $this->belongsToMany(Interest::class, 'profile_interest');
    }

    public function getAvatarUrlAttribute(): ?string
    {
        return $this->avatar_path ? Storage::disk('public')->url($this->avatar_path) : null;
    }

    public function getBannerUrlAttribute(): ?string
    {
        return $this->banner_path ? Storage::disk('public')->url($this->banner_path) : null;
    }

    public function getBirthDayAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function setBirthDayAttribute($value): void
    {
        $this->attributes['birth_day'] = $value ? Carbon::parse($value) : null;
    }

    protected function casts(): array
    {
        return [
            'gender' => UserGenderEnum::class,
            'birth_date' => 'date:Y-m-d',
            'visited_countries' => 'array',
        ];
    }
}
