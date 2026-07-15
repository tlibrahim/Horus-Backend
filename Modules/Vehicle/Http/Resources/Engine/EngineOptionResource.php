<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Resources\Engine;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\Vehicle\Models\Engine;

/**
 * @mixin Engine
 */
final class EngineOptionResource extends BaseResource
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
