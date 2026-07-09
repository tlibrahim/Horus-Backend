<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Resources;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\Vehicle\Models\Engine;

/**
 * @mixin Engine
 */
final class EngineDetailsResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'generation_id' => $this->generation_id,
            'code' => $this->code,
            'name' => $this->name,
            'displacement' => $this->displacement,
            'horse_power' => $this->horse_power,
            'torque' => $this->torque,
            'fuel_type_id' => $this->fuel_type_id,
            'transmission_id' => $this->transmission_id,
            'is_active' => (bool) $this->is_active,
        ];
    }
}
