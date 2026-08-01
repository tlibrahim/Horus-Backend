<?php

declare(strict_types=1);

namespace Modules\OBD\Repositories;

use App\Support\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Modules\OBD\Contracts\Repositories\ObdSessionRepositoryInterface;
use Modules\OBD\Enums\ObdSessionStatus;
use Modules\OBD\Models\ObdSession;
use Modules\OBD\Models\VehicleObdDevice;

final class ObdSessionRepository extends BaseRepository implements ObdSessionRepositoryInterface
{
    protected function model(): string
    {
        return ObdSession::class;
    }

    public function startSession(
        VehicleObdDevice $pairing,
        array $attributes = [],
    ): ObdSession {
        /** @var ObdSession */
        return $this->create(array_merge([
            'vehicle_obd_device_id' => $pairing->id,
            'started_at' => now(),
            'last_activity_at' => now(),
            'status' => ObdSessionStatus::Connecting,
        ], $attributes));
    }

    public function disconnectSession(
        ObdSession $session,
    ): ObdSession {
        $this->update($session, [
            'status' => ObdSessionStatus::Disconnected,
            'ended_at' => now(),
            'last_activity_at' => now(),
        ]);

        /** @var ObdSession */
        return $session->fresh();
    }

    public function heartbeat(
        ObdSession $session,
    ): ObdSession {
        $this->update($session, [
            'last_activity_at' => now(),
        ]);

        /** @var ObdSession */
        return $session->fresh();
    }

    public function activeForPairing(
        VehicleObdDevice $pairing,
    ): ?ObdSession {
        return ObdSession::query()
            ->where('vehicle_obd_device_id', $pairing->id)
            ->active()
            ->latest()
            ->first();
    }

    public function historyForPairing(
        VehicleObdDevice $pairing,
    ): Collection {
        return ObdSession::query()
            ->where('vehicle_obd_device_id', $pairing->id)
            ->latest('started_at')
            ->get();
    }
}
