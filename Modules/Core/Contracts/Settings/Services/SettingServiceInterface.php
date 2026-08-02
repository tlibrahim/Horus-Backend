<?php

declare(strict_types=1);

namespace Modules\Core\Contracts\Settings\Services;

use App\Support\Contracts\CrudServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Models\Setting;

interface SettingServiceInterface extends CrudServiceInterface
{
    public function findByKey(string $key): ?Setting;

    public function getValue(string $key): mixed;

    public function setValue(string $key, mixed $value): Setting;

    public function group(string $group): Collection;
}
