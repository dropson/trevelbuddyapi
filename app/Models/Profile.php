<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserGenderEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullname',
        'avatar_path',
        'birtdate',
        'gender',
        'location',
        'interests',
        'visited_countries',
        'bio',
        'description',
        'profile_completion',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'profile_language')->withPivot('level');
    }

    protected function casts(): array
    {
        return [
            'gender' => UserGenderEnum::class,
            'birthdate' => 'date',
            'interests' => 'array',
            'visited_countries' => 'array',
        ];
    }
}
