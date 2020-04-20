<?php

namespace App\Providers\Project;

use App\Interfaces\Services\IntegrationServiceInterface;
use App\Services\IntegrationService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class IntegrationServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IntegrationServiceInterface::class, function ($app) {
            return new IntegrationService();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [IntegrationServiceInterface::class];
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
