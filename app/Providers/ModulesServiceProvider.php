<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ModulesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $providers = config('modules.providers');

        foreach ($providers as $provider) {
            $this->app->register($provider);
        }
    }
}
