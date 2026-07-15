<?php

declare(strict_types=1);

namespace Modules\Vehicle\Http\Resources\Common;

use App\Support\Http\Resources\BaseResource;

final class LookupResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  mixed  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,

            'name' => $this->name,

            'slug' => $this->when(
                isset($this->slug),
                $this->slug,
            ),

            'logo' => $this->when(
                isset($this->logo),
                $this->logo
            ),

            'icon' => $this->when(
                isset($this->icon),
                $this->icon
            ),
        ];
    }
}
