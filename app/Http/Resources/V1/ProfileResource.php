<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'fullname' => $this->fullname,
            'avatar_path' => $this->avatar,
            'gender' => $this->avatar,
            'birthdate' => $this->birthdate,
            'location' => $this->location,
            'languages' => $this->languages,
            'visited_countries' => [],
            'bio' => $this->bio,
            'description' => $this->description,
            'interests' => [],
            'profile_completion' => $this->profile_completion,
        ];
    }
}
