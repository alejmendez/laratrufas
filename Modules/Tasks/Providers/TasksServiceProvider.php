<?php

namespace Modules\Tasks\Providers;

use Modules\Core\Providers\CoreServiceProvider;

class TasksServiceProvider extends CoreServiceProvider
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
        $this->loadMigrationDirectories('Modules/Tasks/Database/Migrations');
    }
}
