<?php

declare(strict_types=1);

namespace App\Support\Filtering;

final readonly class Filter
{
    public function __construct(
        public string $column,
        public FilterType $type,
    ) {}

    public static function exact(string $column): self
    {
        return new self(
            column: $column,
            type: FilterType::Exact,
        );
    }

    public static function partial(string $column): self
    {
        return new self(
            column: $column,
            type: FilterType::Partial,
        );
    }

    public static function boolean(string $column): self
    {
        return new self(
            column: $column,
            type: FilterType::Boolean,
        );
    }

    public static function in(string $column): self
    {
        return new self(
            column: $column,
            type: FilterType::In,
        );
    }

    public static function nullable(string $column): self
    {
        return new self(
            column: $column,
            type: FilterType::Nullable,
        );
    }

    public static function date(string $column): self
    {
        return new self(
            column: $column,
            type: FilterType::Date,
        );
    }

    public static function dateRange(string $column): self
    {
        return new self(
            column: $column,
            type: FilterType::DateRange,
        );
    }
}
