<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Resources\Generation;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\Vehicle\Models\Generation;

/**
 * @mixin Generation
 */
final class GenerationOptionResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'label' => $this->name,
            'value' => $this->id,
        ];
    }
}
