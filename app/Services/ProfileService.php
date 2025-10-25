<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserProfile;
use InvalidArgumentException;

class ProfileService extends AbstractBaseService
{
    public function update(User $user, array $data): UserProfile
    {
        $hasData = collect($data)->reject(static fn ($value) => $value === null || $value === '')->isNotEmpty();

        if (! $hasData) {
            throw new InvalidArgumentException('Profile data must not be empty.');
        }

        $profile = UserProfile::query()->firstOrNew(['user_id' => $user->id]);
        $profile->fill($data);
        $profile->save();

        $user->fill([
            'about_me' => $data['bio'] ?? $user->about_me,
            'location' => $data['location'] ?? $user->location,
            'website_url' => $data['website_url'] ?? $user->website_url,
        ])->save();

        return $profile;
    }
}
