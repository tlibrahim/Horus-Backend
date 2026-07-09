<?php

use App\Providers\AppServiceProvider;
use Modules\Core\Providers\CoreServiceProvider;
use Modules\IAM\Providers\IAMServiceProvider;
use Modules\Vehicle\Providers\VehicleServiceProvider;

return [
    AppServiceProvider::class,
    CoreServiceProvider::class,
    IAMServiceProvider::class,
    VehicleServiceProvider::class,
];
