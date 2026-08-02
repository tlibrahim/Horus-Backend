<?php

declare(strict_types=1);

namespace Modules\Core\Contracts\Settings\Repositories;

use App\Support\Contracts\CrudRepositoryInterface;
use Modules\Core\Models\Setting;

interface SettingRepositoryInterface extends CrudRepositoryInterface
{
    public function findByKey(string $key): ?Setting;

    public function getValue(string $key): mixed;

    public function setValue(string $key, mixed $value): Setting;

    public function group(string $group): iterable;
}
