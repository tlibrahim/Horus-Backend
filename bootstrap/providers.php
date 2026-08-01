<?php

use App\Providers\AppServiceProvider;
use Modules\Auth\Providers\AuthServiceProvider;
use Modules\Core\Providers\CoreServiceProvider;
use Modules\OBD\Providers\OBDServiceProvider;
use Modules\Vehicle\Providers\VehicleServiceProvider;

return [
    AppServiceProvider::class,
    CoreServiceProvider::class,
    AuthServiceProvider::class,
    VehicleServiceProvider::class,
    OBDServiceProvider::class,
];
