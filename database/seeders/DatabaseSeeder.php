<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserRoleEnum;
use App\Models\Profile;
use App\Models\Trip;
use App\Models\User;
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
        Trip::factory(53)->recycle($travelers)->create();
    }
}
