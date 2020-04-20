<?php
namespace App\Interfaces\Services;

use App\Models\Integration;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Contracts\User as SocialiteUser;

interface IntegrationServiceInterface
{
    /**
     * Redirect to provider authentication URL.
     *
     * @param string $provider
     * @return RedirectResponse
     */
    public function redirect(string $provider): RedirectResponse;

    /**
     * Determine if this integration exists.
     *
     * @param SocialiteUser $user
     * @param string $provider
     * @return bool
     */
    public function exists(SocialiteUser $user, string $provider): bool;

    /**
     * Integrate and link to an account.
     *
     * @param User $user
     * @param SocialiteUser $socialiteUser
     * @param string $provider
     * @return Integration
     */
    public function integrate(User $user, SocialiteUser $socialiteUser, string $provider): Integration;

    /**
     * Integrations of an user.
     *
     * @param User $user
     * @return Collection
     */
    public function integrations(User $user): Collection;
}
