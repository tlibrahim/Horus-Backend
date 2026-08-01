<?php

declare(strict_types=1);

namespace Modules\OBD\Http\Resources;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\OBD\Models\ObdDevice;

/**
 * @mixin ObdDevice
 */
final class ObdDeviceOptionResource extends BaseResource
{
    public function toArray(Request $request): array
    {
        return [
            'label' => sprintf(
                '%s %s (%s)',
                $this->manufacturer,
                $this->model,
                $this->serial_number
            ),

            'value' => $this->id,
        ];
    }
}
