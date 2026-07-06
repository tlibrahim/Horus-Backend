<?php

declare(strict_types=1);

namespace App\Support\Services;

use App\Support\Contracts\ServiceInterface;
use Closure;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * Base application service.
 *
 * Responsibilities:
 * - Database transactions
 * - Shared business-layer utilities
 *
 * Business logic belongs in concrete services,
 * not in controllers or repositories.
 */
abstract class BaseService implements ServiceInterface
{
    /**
     * Execute a callback inside a database transaction.
     *
     * The transaction will automatically commit if the callback
     * completes successfully, or roll back if an exception occurs.
     *
     * @template TReturn
     *
     * @param  Closure(): TReturn  $callback
     * @return TReturn
     *
     * @throws Throwable
     */
    protected function transaction(Closure $callback): mixed
    {
        return DB::transaction($callback);
    }
}
