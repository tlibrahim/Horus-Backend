<?php

declare(strict_types=1);

namespace Modules\OBD\Services;

use App\Support\Exceptions\ConflictException;
use App\Support\Services\BaseCrudService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\OBD\Contracts\Repositories\ObdSessionRepositoryInterface;
use Modules\OBD\Contracts\Services\ObdSessionServiceInterface;
use Modules\OBD\Enums\ObdSessionStatus;
use Modules\OBD\Filters\ObdSessionFilter;
use Modules\OBD\Models\ObdSession;
use Modules\OBD\Models\VehicleObdDevice;

final class ObdSessionService extends BaseCrudService implements ObdSessionServiceInterface
{
    public function __construct(
        private readonly ObdSessionRepositoryInterface $sessions,
    ) {}

    public function all(): iterable
    {
        return $this->allFromRepository();
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->paginateFromRepository($perPage);
    }

    public function options(): Collection
    {
        return $this->optionsFromRepository();
    }

    public function find(int|string $id): ObdSession
    {
        /** @var ObdSession */
        return $this->findFromRepository($id);
    }

    public function create(array $attributes): ObdSession
    {
        $attributes['started_at'] ??= now();

        $attributes['last_activity_at'] ??= $attributes['started_at'];

        $attributes['status'] ??= ObdSessionStatus::Connecting;

        /** @var ObdSession */
        return $this->createFromRepository($attributes);
    }

    public function update(
        ObdSession $session,
        array $attributes,
    ): ObdSession {
        /** @var ObdSession */
        return $this->updateFromRepository($session, $attributes);
    }

    public function toggleStatus(
        ObdSession $session,
        bool $isActive,
    ): ObdSession {
        /** @var ObdSession */
        return $this->toggleStatusOnRepository($session, $isActive);
    }

    public function delete(
        ObdSession $session,
    ): bool {
        return $this->deleteFromRepository($session);
    }

    /*
    |--------------------------------------------------------------------------
    | Session Lifecycle
    |--------------------------------------------------------------------------
    */

    public function startSession(
        VehicleObdDevice $pairing,
        array $attributes = [],
    ): ObdSession {

        if ($this->sessions->activeForPairing($pairing) !== null) {
            throw new ConflictException(
                title: 'Active Session Exists',
                detail: 'This vehicle already has an active OBD session.',
            );
        }

        return $this->sessions->startSession(
            $pairing,
            $attributes,
        );
    }

    public function disconnectSession(
        ObdSession $session,
    ): ObdSession {

        if ($session->isClosed()) {
            throw new ConflictException(
                title: 'Session Already Closed',
                detail: 'This OBD session has already been disconnected.',
            );
        }

        return $this->sessions->disconnectSession($session);
    }

    public function heartbeat(
        ObdSession $session,
    ): ObdSession {

        if ($session->isClosed()) {
            throw new ConflictException(
                title: 'Inactive Session',
                detail: 'Heartbeat cannot be sent for a closed session.',
            );
        }

        return $this->sessions->heartbeat($session);
    }

    public function activeForPairing(
        VehicleObdDevice $pairing,
    ): ?ObdSession {
        return $this->sessions->activeForPairing($pairing);
    }

    public function historyForPairing(
        VehicleObdDevice $pairing,
    ): Collection {
        return $this->sessions->historyForPairing($pairing);
    }

    protected function repository(): ObdSessionRepositoryInterface
    {
        return $this->sessions;
    }

    protected function filterClass(): ?string
    {
        return ObdSessionFilter::class;
    }
}
