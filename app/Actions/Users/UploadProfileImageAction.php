<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\User;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class UploadProfileImageAction
{
    public function handle(User $user, UploadedFile $file, string $type): User
    {
        if (! $file->isValid()) {
            throw new Exception('Invalide file upload');
        }

        $profile = $user->profile;
        $field = $this->getField($type);
        $folder = $this->getFolder($type);

        if ($field && $profile->$field && Storage::disk('public')->exists($profile->$field)) {
            Storage::disk('public')->delete($profile->$field);
        }

        $filename = $user->id.'_'.time().'_'.Str::random(6).'.'.$file->getClientOriginalExtension();

        $path = $file->storeAs($folder, $filename, 'public');

        $profile->$field = $path;

        $profile->save();

        return $user->fresh('profile');
    }

    public function delete(User $user, string $type)
    {
        $profile = $user->profile;

        $field = $this->getField($type);

        if ($field && $profile->$field && Storage::disk('public')->exists($profile->$field)) {
            Storage::disk('public')->delete($profile->$field);
            $profile->$field = null;
            $profile->save();
        }

        return $user->fresh('profile');
    }

    private function getField(string $type): ?string
    {
        return match ($type) {
            'avatar' => 'avatar_path',
            'banner' => 'banner_path',
            default => null,
        };
    }

    private function getFolder(string $type): string
    {
        return match ($type) {
            'avatar' => 'avatars',
            'banner' => 'banners',
            default => 'uploads',
        };
    }
}
