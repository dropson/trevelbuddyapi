<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Services\ProfileCompletionService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $completionServices = app(ProfileCompletionService::class);
        $profile = $this->whenLoaded('profile') ?? [];

        return [
            'id' => $this->id,
            'email' => $this->email,
            'username' => $this->username,
            'role' => $this->getRoleNames(),
            'email_verified' => $this->hasVerifiedEmail(),
            'avatar' => $profile->avatar_url,
            'completion_percentage' => $completionServices->calculate($profile),
        ];
    }
}
