<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Profile;

final class ProfileCompletionService
{
    private array $weights = [
        'full_name' => 10,
        'avatar_path' => 15,
        'birth_date' => 5,
        'gender' => 5,
        'location' => 10,
        'visited_countries' => 15,
        'interests' => 10,
        'bio' => 15,
        'description' => 10,
        'languages' => 5,
    ];

    public function calculate(Profile $profile): int
    {
        $scope = 0;
        foreach ($this->weights as $field => $weight) {
            if ($this->isFilled($profile, $field)) {
                $scope += $weight;
            }
        }

        return min($scope, 100);
    }

    public function checklist(Profile $profile): array
    {
        $checklist = [];
        $total = 0;
        foreach ($this->weights as $field => $weight) {
            $filled = $this->isFilled($profile, $field);
            $earned = $filled ? $weight : 0;

            $checklist[] = [
                'field' => $field,
                'label' => __("profile_fields.$field"),
                'filled' => $filled,
                'weight' => $weight,
            ];
            $total += $earned;
        }

        return [
            'total' => min($total, 100),
            'items' => $checklist,
        ];
    }

    public function isFilled(Profile $profile, string $field): bool
    {
        return match ($field) {
            'visited_countries' => $profile->visited_countries && count($profile->visited_countries) > 0,
            'interests' => $profile->interests && $profile->interests->count() > 0,
            'languages' => $profile->languages && $profile->languages->count() > 0,
            default => ! empty($profile->{$field}),
        };
    }
}
