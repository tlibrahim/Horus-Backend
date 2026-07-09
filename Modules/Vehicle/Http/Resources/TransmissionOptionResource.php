<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Resources;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\Vehicle\Models\Transmission;

/** @mixin Transmission */
final class TransmissionOptionResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return ['label' => $this->name, 'value' => $this->id];
    }
}
