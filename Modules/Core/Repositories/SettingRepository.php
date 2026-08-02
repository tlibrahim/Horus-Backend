<?php

declare(strict_types=1);

namespace Modules\Core\Repositories;

use App\Support\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Modules\Core\Contracts\Settings\Repositories\SettingRepositoryInterface;
use Modules\Core\Models\Setting;

final class SettingRepository extends BaseRepository implements SettingRepositoryInterface
{
    private const CACHE_PREFIX = 'settings:';

    protected function model(): string
    {
        return Setting::class;
    }

    public function findByKey(string $key): ?Setting
    {
        /** @var Setting|null */
        return Setting::query()
            ->where('key', $key)
            ->first();
    }

    public function getValue(string $key): mixed
    {
        return Cache::rememberForever(
            self::CACHE_PREFIX.$key,
            function () use ($key): mixed {
                return $this->findByKey($key)?->value;
            }
        );
    }

    public function setValue(
        string $key,
        mixed $value,
    ): Setting {
        /** @var Setting $setting */
        $setting = Setting::query()
            ->where('key', $key)
            ->firstOrFail();

        $this->update($setting, [
            'value' => $value,
        ]);

        Cache::forget(self::CACHE_PREFIX.$key);

        /** @var Setting */
        return $setting->fresh();
    }

    public function group(string $group): Collection
    {
        return Cache::rememberForever(
            self::CACHE_PREFIX.'group:'.$group,
            function () use ($group): Collection {
                return Setting::query()
                    ->where('group', $group)
                    ->orderBy('key')
                    ->get();
            }
        );
    }

    /**
     * Clear cached setting(s).
     */
    public function forgetCache(?string $key = null): void
    {
        if ($key !== null) {
            Cache::forget(self::CACHE_PREFIX.$key);

            return;
        }

        // Since Laravel doesn't support deleting by prefix on every cache driver,
        // callers should clear the cache store or forget specific keys as needed.
        Cache::flush();
    }
}
