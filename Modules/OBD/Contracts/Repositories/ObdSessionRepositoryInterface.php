<?php

declare(strict_types=1);

namespace Modules\OBD\Contracts\Repositories;

use App\Support\Contracts\CrudRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Modules\OBD\Models\ObdSession;
use Modules\OBD\Models\VehicleObdDevice;

interface ObdSessionRepositoryInterface extends CrudRepositoryInterface
{
    public function startSession(
        VehicleObdDevice $pairing,
        array $attributes = [],
    ): ObdSession;

    public function disconnectSession(
        ObdSession $session,
    ): ObdSession;

    public function heartbeat(
        ObdSession $session,
    ): ObdSession;

    public function activeForPairing(
        VehicleObdDevice $pairing,
    ): ?ObdSession;

    public function historyForPairing(
        VehicleObdDevice $pairing,
    ): Collection;
}
