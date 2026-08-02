<?php

declare(strict_types=1);

namespace Modules\Core\Filters;

use App\Support\Filtering\AbstractFilter;

final class FeatureFlagFilter extends AbstractFilter
{
    protected function filters(): array
    {
        return [
            'enabled',
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
            'enabled',
            'created_at',
        ];
    }
}
