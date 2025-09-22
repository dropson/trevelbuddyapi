<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\TripMateStatusEnum;
use App\Enums\UserRoleEnum;
use App\Models\Profile;
use App\Models\Trip;
use App\Models\TripMate;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CountrySeeder::class,
            CategorySeeder::class,
            LanguageSeeder::class,
            InterestSeeder::class,
            RolesAndPermissionSeeder::class,
        ]);

        $moderator = User::factory()->create([
            'email' => 'test@example.com',
        ]);
        $moderator->profile()->create(
            [
                'full_name' => 'Moderator',
                'gender' => 'male',
            ]
        );
        $moderator->assignRole(UserRoleEnum::MODERATOR->value);

        $travelers = User::factory(20)->has(Profile::factory())->create()->each(function ($user): void {
            $user->assignRole(UserRoleEnum::TRAVELER->value);
        });
        $trips = Trip::factory(53)->recycle($travelers)->create();

        $trips->each(function (Trip $trip) use ($travelers) {
            $max = min(2, $trip->max_mates);
            $count = fake()->numberBetween(2, $max);
            $mates = $travelers->where('id', '!=', $trip->creator_id)->random($count);
            TripMate::factory()->count($mates->count())->state(new Sequence(
                fn($sequence) => [
                    'trip_id' => $trip->id,
                    'user_id' => $mates->get($sequence->index)->id,
                    'status'  => fake()->randomElement([
                        TripMateStatusEnum::APPROVED,
                        TripMateStatusEnum::PENDING,
                    ]),
                ]
            ))
                ->create();
        });
    }
}
