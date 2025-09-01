<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Interest;
use Illuminate\Database\Seeder;

final class InterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $interests = [
            'Hiking',
            'Traveling',
            'Backpacking',
            'Cities',
            'Camping',
            'Music',
            'Movies',
            'Technology',
            'Canoeing',
            'Cycling',
            'Fishing',
            'Photography',
            'Running',
            'Snowboarding',
            'Surfing',
            'Volunteering',
            'Yoga',
            'Motorized Sports',
            'Safaris',
            'Trekking',
            'Dancing',
            'Sailing',
        ];
        foreach ($interests as $interest) {
            Interest::firstOrCreate(['name' => $interest]);
        }
    }
}
