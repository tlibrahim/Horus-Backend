<?php

declare(strict_types=1);

namespace Modules\Core\Contracts\FeatureFlags\Repositories;

use App\Support\Contracts\CrudRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Models\FeatureFlag;

interface FeatureFlagRepositoryInterface extends CrudRepositoryInterface
{
    public function findByKey(string $key): ?FeatureFlag;

    public function isEnabled(string $key): bool;

    public function enable(string $key): FeatureFlag;

    public function disable(string $key): FeatureFlag;

    public function enabled(): Collection;

    public function disabled(): Collection;
}
