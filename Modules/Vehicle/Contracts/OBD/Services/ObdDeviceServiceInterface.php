<?php

declare(strict_types=1);

namespace Modules\Vehicle\Contracts\OBD\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Vehicle\Models\ObdDevice;

interface ObdDeviceServiceInterface
{
    public function all(): iterable;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function find(int|string $id): ObdDevice;

    public function create(array $attributes): ObdDevice;

    public function update(ObdDevice $obdDevice, array $attributes): ObdDevice;

    public function options(): Collection;

    public function toggleStatus(ObdDevice $obdDevice, bool $isActive): ObdDevice;

    public function delete(ObdDevice $obdDevice): bool;
}
