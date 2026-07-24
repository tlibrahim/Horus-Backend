<?php

declare(strict_types=1);

namespace Modules\Vehicle\Contracts\OBD\Repositories;

use App\Support\Contracts\CrudRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Modules\Vehicle\Models\ObdSession;
use Modules\Vehicle\Models\VehicleObdDevice;

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
