<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\DTOs\ProfileDTO;
use App\Models\User;

final class UploadProfileInformationAction
{
    public function handle(ProfileDTO $dto, User $user): User
    {
        $profile = $user->profile;

        $profile->fill([
            'full_name' => $dto->fullname,
            'gender' => $dto->gender,
            'birth_date' => $dto->birthdate,
            'country_id' => $dto->country,
            'city' => $dto->city,
            'visited_countries' => $dto->visited_countries,
            'bio' => $dto->bio,
            'description' => $dto->description,
            'interests' => $dto->interests,
        ]);
        $profile->save();

        if ($dto->languages !== null) {
            $profile->languages()->sync($dto->languages);
        }
        if ($dto->interests !== null) {
            $profile->interests()->sync($dto->interests);
        }

        return $user->fresh('profile');
    }
}
