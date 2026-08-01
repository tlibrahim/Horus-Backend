<?php

declare(strict_types=1);

namespace Modules\OBD\Http\Resources\Sessions;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\OBD\Models\ObdSession;

/**
 * @mixin ObdSession
 */
final class ObdSessionOptionResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'label' => sprintf(
                '%s (%s)',
                $this->session_uuid,
                $this->status?->label(),
            ),

            'value' => $this->id,
        ];
    }
}
