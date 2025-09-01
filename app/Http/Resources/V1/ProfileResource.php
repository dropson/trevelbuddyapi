<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use App\Services\ProfileCompletionService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $completionServices = app(ProfileCompletionService::class);

        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'avatar' => $this->avatar_url,
            'banner' => $this->banner_url,
            'gender' => $this->gender,
            'birth_date' => $this->birth_date,
            'location' => $this->location,
            'languages' => LanguageResource::collection($this->languages),
            'visited_countries' => $this->visited_countries,
            'bio' => $this->bio,
            'description' => $this->description,
            'interests' => InterestResource::collection($this->interests),
            'completion_percentage' => $completionServices->calculate($request->user()->profile),
            'completion_checklist' => $completionServices->checklist($request->user()->profile),
        ];
    }
}
