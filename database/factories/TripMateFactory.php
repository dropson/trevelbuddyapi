<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\TripMateStatusEnum;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


final class TripMateFactory extends Factory
{

    public function definition(): array
    {
        return [
            'trip_id' => Trip::factory(),
            'user_id' => User::factory(),
            'status' => fake()->randomElement(TripMateStatusEnum::cases())
        ];
    }
}
