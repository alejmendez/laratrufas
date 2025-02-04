<?php

namespace Modules\Dashboard\Providers;

use Modules\Core\Providers\CoreServiceProvider;

class DashboardServiceProvider extends CoreServiceProvider
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
        // $this->loadMigrationDirectories('Modules/Dashboard/Database/Migrations');
    }
}
