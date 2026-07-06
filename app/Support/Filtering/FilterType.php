<?php

declare(strict_types=1);

namespace App\Support\Filtering;

enum FilterType: string
{
    case Exact = 'exact';

    case Partial = 'partial';

    case Boolean = 'boolean';

    case In = 'in';

    case Nullable = 'nullable';

    case Date = 'date';

    case DateRange = 'date_range';
}
