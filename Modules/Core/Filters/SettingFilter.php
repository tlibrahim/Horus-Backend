<?php

declare(strict_types=1);

namespace Modules\Core\Filters;

use App\Support\Filtering\AbstractFilter;

final class SettingFilter extends AbstractFilter
{
    protected function filters(): array
    {
        return [
            'group',
            'type',
            'is_public',
            'key',
        ];
    }

    protected function searches(): array
    {
        return [
            'key',
            'description',
        ];
    }

    protected function sorts(): array
    {
        return [
            'key',
            'group',
            'created_at',
        ];
    }
}
