<?php

declare(strict_types=1);

namespace Modules\Core\Repositories;

use App\Support\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Modules\Core\Contracts\FeatureFlags\Repositories\FeatureFlagRepositoryInterface;
use Modules\Core\Models\FeatureFlag;

final class FeatureFlagRepository extends BaseRepository implements FeatureFlagRepositoryInterface
{
    private const CACHE_PREFIX = 'feature_flags:';

    protected function model(): string
    {
        return FeatureFlag::class;
    }

    public function findByKey(string $key): ?FeatureFlag
    {
        /** @var FeatureFlag|null */
        return $this->query()
            ->where('key', $key)
            ->first();
    }

    public function isEnabled(string $key): bool
    {
        return Cache::rememberForever(
            self::CACHE_PREFIX.$key,
            function () use ($key): bool {
                return (bool) $this->query()
                    ->where('key', $key)
                    ->value('enabled');
            }
        );
    }

    public function enable(string $key): FeatureFlag
    {
        return $this->setEnabled($key, true);
    }

    public function disable(string $key): FeatureFlag
    {
        return $this->setEnabled($key, false);
    }

    public function enabled(): Collection
    {
        return $this->query()
            ->where('enabled', true)
            ->orderBy('key')
            ->get();
    }

    public function disabled(): Collection
    {
        return $this->query()
            ->where('enabled', false)
            ->orderBy('key')
            ->get();
    }

    private function setEnabled(
        string $key,
        bool $enabled,
    ): FeatureFlag {
        /** @var FeatureFlag $feature */
        $feature = $this->query()
            ->where('key', $key)
            ->firstOrFail();

        $this->update($feature, [
            'enabled' => $enabled,
        ]);

        Cache::forget(self::CACHE_PREFIX.$key);

        /** @var FeatureFlag */
        return $feature->fresh();
    }
}
