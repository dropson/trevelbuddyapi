<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

final class Interest extends Model
{
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'profile_interest');
    }
}
