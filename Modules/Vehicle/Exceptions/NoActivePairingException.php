<?php

namespace Modules\Vehicle\Exceptions;

use App\Support\Exceptions\NotFoundException;

final class NoActivePairingException extends NotFoundException
{
    public function __construct()
    {
        parent::__construct(
            title: 'No Active Pairing',
            detail: 'This OBD device is not actively paired with any vehicle.',
        );
    }
}
