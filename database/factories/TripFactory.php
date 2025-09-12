<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\TripAccommodationEnum;
use App\Enums\TripStatusEnum;
use App\Enums\UserGenderEnum;
use App\Models\Category;
use App\Models\Country;
use App\Models\Language;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

final class TripFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(5);
        $status = fake()->randomElement(TripStatusEnum::cases());

        return [
            'creator_id' => User::factory(),
            'country_id' => fake()->randomElement(Country::get()),
            // 'image_path',
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => fake()->paragraph(),
            'start_date' => fake()->dateTime(),
            'end_date' => fake()->dateTime(),
            'status' => $status,
            'category_id' => fake()->randomElement(Category::get()),
            'cancel_reason' => $status === TripStatusEnum::REJECTED ? fake()->sentence(5) : null,
            'max_mates' => random_int(1, 4),
            'gender_preference' => fake()->randomElement(UserGenderEnum::cases()),
            'accommodation' => fake()->randomElement(TripAccommodationEnum::cases()),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Trip $trip): void {
            $languages = Language::inRandomOrder()->take(random_int(1, 2))->pluck('id');
            $trip->languages()->attach($languages);
        });
    }
}
