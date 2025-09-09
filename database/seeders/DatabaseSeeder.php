<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserRoleEnum;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            CountrySeeder::class,
            CategorySeeder::class,
            LanguageSeeder::class,
            InterestSeeder::class,
            RolesAndPermissionSeeder::class,
        ]);
        $user = User::factory()->create([
            'email' => 'test@example.com',
        ]);
        $user->profile()->create();
        $user->assignRole(UserRoleEnum::TRAVELER->value);
    }
}
