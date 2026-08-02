<?php

declare(strict_types=1);

namespace Modules\Core\Contracts\FeatureFlags\Services;

use App\Support\Contracts\CrudServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Models\FeatureFlag;

interface FeatureFlagServiceInterface extends CrudServiceInterface
{
    public function findByKey(string $key): ?FeatureFlag;

    public function isEnabled(string $key): bool;

    public function enable(string $key): FeatureFlag;

    public function disable(string $key): FeatureFlag;

    public function enabled(): Collection;

    public function disabled(): Collection;
}
