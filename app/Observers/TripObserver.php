<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Trip;
use Illuminate\Support\Str;

final class TripObserver
{
    public function created(Trip $trip): void
    {
        $trip->slug = Str::slug($trip->title).'-'.$trip->id;
        $trip->saveQuietly();
    }

    public function updating(Trip $trip): void
    {
        if ($trip->isDirty('title')) {
            $trip->slug = Str::slug($trip->title).'-'.$trip->id;
        }
    }
}
