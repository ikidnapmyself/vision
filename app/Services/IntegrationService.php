<?php

namespace App\Services;

use App\Interfaces\Services\IntegrationServiceInterface;
use App\Models\Integration;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Laravel\Socialite\Facades\Socialite;

class IntegrationService implements IntegrationServiceInterface
{
    /**
     * @inheritDoc
     */
    public function redirect(string $provider): RedirectResponse
    {
        return Socialite::driver($provider)
            ->scopes(config("services.{$provider}.scopes"))
            ->stateless()
            ->redirect();
    }

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
        return Integration::create([
            'user_id'       => $user->id,
            'provider_name' => $provider,
            'provider_id'   => $socialiteUser->getId(),
            'access_token'  => $socialiteUser->token,
            'profile'       => $socialiteUser->user,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function integrations(User $user): Collection
    {
        return Integration::where('user_id', $user->id)->get();
    }
}
