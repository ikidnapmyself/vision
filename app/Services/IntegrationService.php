<?php

namespace App\Services;

use App\Interfaces\Services\IntegrationServiceInterface;
use App\Models\Integration;
use App\Models\User;
use App\Repositories\IntegrationRepository;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class IntegrationService implements IntegrationServiceInterface
{
    /**
     * @inheritDoc
     */
    public function exists(SocialiteUser $user, string $provider): bool
    {
        $find = Integration::with('user')->where([
            'provider_name' => $provider,
            'provider_id'   => $user->getId(),
        ])->count();

        return (bool) $find;
    }

    /**
     * @inheritDoc
     */
    public function integrate(User $user, SocialiteUser $socialiteUser, string $provider): Integration
    {
        $find = Integration::create([
            'user_id'       => $user->id,
            'provider_name' => $provider,
            'provider_id'   => $socialiteUser->getId(),
            'access_token'  => $socialiteUser->token,
            'profile'       => $socialiteUser->user,
        ]);

        return $find;
    }

    /**
     * @inheritDoc
     */
    public function retrieve(SocialiteUser $user, string $provider): Integration
    {
        $find = Integration::with('user')->findWhere([
            'provider_name' => $provider,
            'provider_id'   => $user->getId(),
        ])->first();

        return $find;
    }
}
