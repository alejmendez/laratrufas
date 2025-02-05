<?php

namespace Modules\Auth\Providers;

use Modules\Core\Providers\CoreServiceProvider;
use Illuminate\Support\Facades\Route;

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
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        Route::middleware('web')->group(base_path('Modules/Auth/Routes/web.php'));
    }
}
