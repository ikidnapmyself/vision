<?php

namespace Tests\Unit;

use App\Interfaces\Services\IntegrationServiceInterface;
use App\Models\Integration;
use App\Models\User;
use Illuminate\Support\Str;
use Mockery;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Tests\TestCase;

class IntegrationTest extends TestCase
{
    /**
     * Integration service.
     * @var IntegrationServiceInterface $service
     */
    protected IntegrationServiceInterface $service;

    /**
     * Integration model.
     * @var Integration $integration
     */
    protected Integration $integration;

    /**
     * Setup testing
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->service     = app(IntegrationServiceInterface::class);
        $this->integration = factory(Integration::class)->create();

        $this->integration->fresh(); // To retrieve from DB'to have missin attributes
    }

    /**
     * Testing redirect method.
     *
     * @return void
     */
    public function testRedirect()
    {
        $provider = factory(Integration::class)->make();
        $redirect = $this->service->redirect($provider->provider_name);

        $this->assertEquals(302, $redirect->getStatusCode());

        if('github' === $provider->provider_name)
            $this->assertStringContainsString('github.com/login/oauth', $redirect->getTargetUrl());
    }

    /**
     * Testing exists method.
     *
     * @return void
     */
    public function testExists()
    {
        $provider      = factory(Integration::class)->create();
        $databaseUser  = $provider->user;

        $socialiteUser = Mockery::mock(SocialiteUser::class);
        $socialiteUser->shouldReceive([
            'getId'       => $provider->provider_id,
            'getName'     => $databaseUser->full_name,
            'getNickname' => Str::kebab($databaseUser->full_name),
            'getAvatar'   => Str::random(),
            'getEmail'    => $databaseUser->email,
        ]);

        $exists = $this->service->exists($socialiteUser, $provider->provider_name);
        $this->assertTrue($exists);
    }

    /**
     * Testing integrate method.
     *
     * @return void
     */
    public function testIntegrate()
    {
        $user = factory(User::class)->create();

        $socialiteUser = Mockery::mock(SocialiteUser::class);
        $socialiteUser->shouldReceive([
                'getId'       => Str::random(),
                'getName'     => $user->full_name,
                'getNickname' => Str::kebab($user->full_name),
                'getAvatar'   => Str::random(),
                'getEmail'    => $user->email,
                'token'       => Str::random(),
            ])
            ->set('token', Str::random())
            ->set('user', ['username' => $user->full_name, 'email' => $user->email]);

        $integrate = $this->service->integrate($user, $socialiteUser, 'provider_name');

        // Integration model created
        $this->assertTrue($integrate->exists);
        $this->assertEquals(
            $user->only(['id', 'name', 'email']),
            $integrate->user->only(['id', 'name', 'email'])
        );
    }

    /**
     * Testing integrations method.
     *
     * @return void
     */
    public function testIntegrations()
    {
        $user         = factory(User::class)->create();
        $integrations = factory(Integration::class, 2)->create(['user_id' => $user->id]);

        $list = $this->service->integrations($user);

        $this->assertCount(2, $list);
        $this->assertEquals(
            $integrations->pluck('provider_name')->sort(),
            $list->pluck('provider_name')->sort()
        );
    }
}
