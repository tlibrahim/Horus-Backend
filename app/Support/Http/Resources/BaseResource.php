<?php

declare(strict_types=1);

namespace App\Support\Http\Resources;

use DateTimeInterface;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class BaseResource extends JsonResource
{
    /**
     * Format a date as ISO 8601.
     */
    protected function formatDate(?DateTimeInterface $date): ?string
    {
        return $date?->format(DATE_ATOM);
    }
}
