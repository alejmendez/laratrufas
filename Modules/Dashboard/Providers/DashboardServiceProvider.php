<?php

namespace Modules\Dashboard\Providers;

use Modules\Core\Providers\CoreServiceProvider;
use Illuminate\Support\Facades\Route;

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
        // $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        Route::middleware('web')->group(base_path('Modules/Dashboard/Routes/web.php'));
    }
}
