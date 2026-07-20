<?php

declare(strict_types=1);

namespace Modules\Vehicle\Services;

use App\Support\Services\BaseCrudService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Vehicle\Contracts\OBD\Repositories\ObdDeviceRepositoryInterface;
use Modules\Vehicle\Contracts\OBD\Services\ObdDeviceServiceInterface;
use Modules\Vehicle\Enums\ObdDeviceStatus;
use Modules\Vehicle\Filters\ObdDeviceFilter;
use Modules\Vehicle\Models\ObdDevice;

final class ObdDeviceService extends BaseCrudService implements ObdDeviceServiceInterface
{
    public function __construct(
        private readonly ObdDeviceRepositoryInterface $devices,
    ) {}

    public function all(): Collection
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

    public function find(int|string $id): ObdDevice
    {
        /** @var ObdDevice */
        return $this->findFromRepository($id);
    }

    public function create(array $attributes): ObdDevice
    {
        /** @var ObdDevice */
        return $this->createFromRepository($attributes);
    }

    public function update(
        ObdDevice $obdDevice,
        array $attributes,
    ): ObdDevice {
        /** @var ObdDevice */
        return $this->updateFromRepository($obdDevice, $attributes);
    }

    public function toggleStatus(
        ObdDevice $obdDevice,
        bool $isActive,
    ): ObdDevice {
        /** @var ObdDevice */
        return $this->updateFromRepository(
            $obdDevice,
            [
                'status' => $isActive
                    ? ObdDeviceStatus::Active->value
                    : ObdDeviceStatus::Inactive->value,
            ],
        );
    }

    public function delete(ObdDevice $obdDevice): bool
    {
        return $this->deleteFromRepository($obdDevice);
    }

    protected function repository(): ObdDeviceRepositoryInterface
    {
        return $this->devices;
    }

    protected function filterClass(): ?string
    {
        return ObdDeviceFilter::class;
    }
}
