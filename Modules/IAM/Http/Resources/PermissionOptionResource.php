<?php

declare(strict_types=1);

namespace Modules\IAM\Http\Resources;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\IAM\Models\Permission;

/** @mixin Permission */
final class PermissionOptionResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'label' => $this->name,
            'value' => $this->id,
            'code' => $this->code,
        ];
    }
}
