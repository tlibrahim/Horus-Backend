<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Resources;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\Vehicle\Models\Generation;

/**
 * @mixin Generation
 */
final class GenerationResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'model_id' => $this->model_id,
            'name' => $this->name,
            'start_year' => $this->start_year,
            'end_year' => $this->end_year,
            'is_active' => (bool) $this->is_active,
        ];
    }
}
