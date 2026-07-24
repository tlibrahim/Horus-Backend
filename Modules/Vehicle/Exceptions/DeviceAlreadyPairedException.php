<?php

namespace Modules\Vehicle\Exceptions;

use App\Support\Exceptions\ConflictException;

final class DeviceAlreadyPairedException extends ConflictException
{
    public function __construct()
    {
        parent::__construct(
            title: 'Device Already Paired',
            detail: 'This OBD device is already paired with another vehicle.',
        );
    }
}
