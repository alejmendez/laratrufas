<?php

return [
    'providers' => [
        Modules\Core\Providers\CoreServiceProvider::class,
        Modules\Auth\Providers\AuthServiceProvider::class,
        Modules\Users\Providers\UsersServiceProvider::class,
        Modules\Dashboard\Providers\DashboardServiceProvider::class,
        Modules\Tasks\Providers\TasksServiceProvider::class,
        Modules\Fields\Providers\FieldsServiceProvider::class,
    ],
];
