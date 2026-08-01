<?php

declare(strict_types=1);

namespace Modules\OBD\Contracts\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\OBD\Models\ObdSession;
use Modules\OBD\Models\VehicleObdDevice;

interface ObdSessionServiceInterface
{
    public function all(): iterable;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(int|string $id): ObdSession;

    public function create(array $attributes): ObdSession;

    public function update(
        ObdSession $session,
        array $attributes,
    ): ObdSession;

    public function options(): Collection;

    public function toggleStatus(
        ObdSession $session,
        bool $isActive,
    ): ObdSession;

    public function delete(
        ObdSession $session,
    ): bool;

    /*
    |--------------------------------------------------------------------------
    | Session Lifecycle
    |--------------------------------------------------------------------------
    */

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
