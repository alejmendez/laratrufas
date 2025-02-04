<?php

namespace Modules\Fields\Providers;

use Modules\Core\Providers\CoreServiceProvider;

class FieldsServiceProvider extends CoreServiceProvider
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
        $this->loadMigrationDirectories('Modules/Fields/Database/Migrations');
    }
}
