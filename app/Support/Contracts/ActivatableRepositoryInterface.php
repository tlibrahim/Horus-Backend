<?php

declare(strict_types=1);

namespace App\Support\Contracts;

use Illuminate\Database\Eloquent\Model;

interface ActivatableRepositoryInterface extends CrudRepositoryInterface
{
    public function toggleStatus(Model $model, bool $isActive): Model;

    public function activate(Model $model): Model;

    public function deactivate(Model $model): Model;
}
