<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserGenderEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullname',
        'avatar_path',
        'birtdate',
        'gender',
        'country',
        'languages',
        'visited_countries',
        'bio',
        'description'
    ];

    protected function casts(): array
    {
        return [
            'gender' => UserGenderEnum::class,
            'birthdate' => 'date',
            'languages' => 'array',
            'visited_countries' => 'array'
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
