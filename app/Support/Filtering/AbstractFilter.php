<?php

declare(strict_types=1);

namespace App\Support\Filtering;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class AbstractFilter implements FilterInterface
{
    protected Builder $builder;

    public function __construct(
        protected readonly Request $request,
    ) {}

    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->requestFilters() as $key => $value) {
            if ($this->isEmpty($value)) {
                continue;
            }

            $filter = $this->findFilter($key);

            if ($filter === null) {
                continue;
            }

            $this->applyFilter($filter, $value);
        }

        return $this->builder;
    }

    /**
     * @return array<int, Filter>
     */
    abstract protected function filters(): array;

    /**
     * @return array<string, mixed>
     */
    protected function requestFilters(): array
    {
        return $this->request->input('filter', []);
    }

    protected function builder(): Builder
    {
        return $this->builder;
    }

    protected function isEmpty(mixed $value): bool
    {
        return $value === null || $value === '';
    }

    protected function findFilter(string $column): ?Filter
    {
        foreach ($this->filters() as $filter) {
            if ($filter->column === $column) {
                return $filter;
            }
        }

        return null;
    }

    protected function applyFilter(
        Filter $filter,
        mixed $value,
    ): void {
        match ($filter->type) {
            FilterType::Exact => $this->applyExact($filter, $value),
            FilterType::Partial => $this->applyPartial($filter, $value),
            FilterType::Boolean => $this->applyBoolean($filter, $value),
            FilterType::In => $this->applyIn($filter, $value),
            FilterType::Nullable => $this->applyNullable($filter, $value),
            FilterType::Date => $this->applyDate($filter, $value),
            FilterType::DateRange => $this->applyDateRange($filter, $value),
        };
    }

    protected function applyExact(Filter $filter, mixed $value): void
    {
        $this->builder()->where(
            $filter->column,
            $value,
        );
    }

    protected function applyPartial(Filter $filter, mixed $value): void
    {
        $this->builder()->where(
            $filter->column,
            'ILIKE',
            "%{$value}%",
        );
    }

    protected function applyBoolean(Filter $filter, mixed $value): void
    {
        $this->builder()->where(
            $filter->column,
            filter_var($value, FILTER_VALIDATE_BOOLEAN),
        );
    }

    protected function applyIn(Filter $filter, mixed $value): void
    {
        $values = is_array($value)
            ? $value
            : explode(',', (string) $value);

        $this->builder()->whereIn(
            $filter->column,
            $values,
        );
    }

    protected function applyNullable(Filter $filter, mixed $value): void
    {
        if (filter_var($value, FILTER_VALIDATE_BOOLEAN)) {
            $this->builder()->whereNull($filter->column);

            return;
        }

        $this->builder()->whereNotNull($filter->column);
    }

    protected function applyDate(Filter $filter, mixed $value): void
    {
        $this->builder()->whereDate(
            $filter->column,
            $value,
        );
    }

    protected function applyDateRange(Filter $filter, mixed $value): void
    {
        if (! is_array($value)) {
            return;
        }

        $from = $value['from'] ?? null;
        $to = $value['to'] ?? null;

        if ($from !== null) {
            $this->builder()->whereDate(
                $filter->column,
                '>=',
                $from,
            );
        }

        if ($to !== null) {
            $this->builder()->whereDate(
                $filter->column,
                '<=',
                $to,
            );
        }
    }
}
