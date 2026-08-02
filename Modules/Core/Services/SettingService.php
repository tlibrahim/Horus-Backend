<?php

declare(strict_types=1);

namespace Modules\Core\Services;

use App\Support\Services\BaseCrudService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Contracts\Settings\Repositories\SettingRepositoryInterface;
use Modules\Core\Contracts\Settings\Services\SettingServiceInterface;
use Modules\Core\Filters\SettingFilter;
use Modules\Core\Models\Setting;

final class SettingService extends BaseCrudService implements SettingServiceInterface
{
    public function __construct(
        private readonly SettingRepositoryInterface $settings,
    ) {}

    /*
    |--------------------------------------------------------------------------
    | CRUD
    |--------------------------------------------------------------------------
    */

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

    public function find(int|string $id): Setting
    {
        /** @var Setting */
        return $this->findFromRepository($id);
    }

    public function create(array $attributes): Setting
    {
        /** @var Setting */
        return $this->createFromRepository($attributes);
    }

    public function update(
        Setting $setting,
        array $attributes,
    ): Setting {
        /** @var Setting */
        return $this->updateFromRepository(
            $setting,
            $attributes,
        );
    }

    public function delete(
        Setting $setting,
    ): bool {
        return $this->deleteFromRepository($setting);
    }

    /*
    |--------------------------------------------------------------------------
    | Business Methods
    |--------------------------------------------------------------------------
    */

    public function findByKey(string $key): ?Setting
    {
        return $this->settings->findByKey($key);
    }

    public function getValue(string $key): mixed
    {
        return $this->settings->getValue($key);
    }

    public function setValue(
        string $key,
        mixed $value,
    ): Setting {
        return $this->settings->setValue(
            $key,
            $value,
        );
    }

    public function group(
        string $group,
    ): Collection {
        return $this->settings->group($group);
    }

    /*
    |--------------------------------------------------------------------------
    | BaseCrudService
    |--------------------------------------------------------------------------
    */

    protected function repository(): SettingRepositoryInterface
    {
        return $this->settings;
    }

    protected function filterClass(): ?string
    {
        return SettingFilter::class;
    }
}
