<?php

namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // $this->loadMigrationDirectories('Modules/Core/Database/Migrations');
    }

    public function loadMigrationDirectories($path): void
    {
        $migrationPath = base_path($path);
        $migrations = glob($migrationPath . '/*', GLOB_ONLYDIR);
        $paths = array_merge($migrations, [$migrationPath]);
        $this->loadMigrationsFrom($paths);
    }
}
