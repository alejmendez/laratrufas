<?php

namespace Modules\Auth\Providers;

use Modules\Core\Providers\CoreServiceProvider;

class AuthServiceProvider extends CoreServiceProvider
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
        $this->loadMigrationDirectories('Modules/Auth/Database/Migrations');
    }
}
