<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\UserGenderEnum;
use App\Models\Country;
use App\Models\Interest;
use App\Models\Language;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

final class ProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'full_name' => fake()->firstName().' '.fake()->lastName(),
            // 'avatar_path',
            // 'banner_path',
            'birth_date' => fake()->dateTime(),
            'gender' => fake()->randomElement(UserGenderEnum::cases()),
            'country_id' => fake()->randomElement(Country::get()),
            'city' => fake()->city(),
            'visited_countries' => fake()->randomElements(Country::get()->pluck('code'), random_int(4, 10)),
            'bio' => fake()->text(130),
            'description' => fake()->text(160),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Profile $profile): void {
            $languages = Language::inRandomOrder()->take(random_int(1, 3))->pluck('id');
            $profile->languages()->attach($languages);

            $interesets = Interest::inRandomOrder()->take(random_int(3, 5))->pluck('id');
            $profile->interests()->attach($interesets);
        });
    }
}
