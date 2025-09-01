<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\V1;

use App\Actions\Users\UploadProfileImageAction;
use App\Actions\Users\UploadProfileInformationAction;
use App\DTOs\ProfileDTO;
use App\Http\Controllers\ApiController;
use App\Http\Requests\V1\ProfileUploadRequest;
use App\Http\Resources\V1\ProfileResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ProfileController extends ApiController
{
    public function show(Request $request): ProfileResource
    {
        return new ProfileResource($request->user()->profile->load('languages', 'interests'));
    }

    public function setAvatar(Request $request, UploadProfileImageAction $action): JsonResponse
    {
        $request->validate([
            'image' => ['required', 'file', 'mimes:png,jpg', 'max:2048'],
        ]);

        $user = $action->handle($request->user(), $request->file('image'), 'avatar');

        return $this->success('Avatar successfully added', new ProfileResource($user->profile));
    }

    public function deleteAvatar(Request $request, UploadProfileImageAction $action): JsonResponse
    {
        $user = $action->delete($request->user(), 'avatar');

        return $this->success('Avatar successfully deleted', new ProfileResource($user->profile));
    }

    public function setBanner(Request $request, UploadProfileImageAction $action): JsonResponse
    {
        $request->validate([
            'image' => ['required', 'file', 'mimes:png,jpg', 'max:2048'],
        ]);

        $user = $action->handle($request->user(), $request->file('image'), 'banner');

        return $this->success('Banenr successfully added', new ProfileResource($user->profile));
    }

    public function deleteBanner(Request $request, UploadProfileImageAction $action): JsonResponse
    {
        $user = $action->delete($request->user(), 'banner');

        return $this->success('Banner successfully deleted', new ProfileResource($user->profile));
    }

    public function updateProfile(ProfileUploadRequest $request, UploadProfileInformationAction $action): JsonResponse
    {
        $action->handle(ProfileDTO::fromRequest($request), $request->user());

        return $this->success('Information successfully updated', new ProfileResource($request->user()->profile->load('languages', 'interests')));
    }
}
