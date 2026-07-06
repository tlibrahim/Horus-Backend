<?php

declare(strict_types=1);

namespace Modules\Core\Http\Resources;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\Core\Models\Currency;

/**
 * @mixin Currency
 */
final class CurrencyResource extends BaseResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'code' => $this->code,
            'symbol' => $this->symbol,
            'name' => $this->name,
            'currency_symbol' => $this->currency_symbol,

            'is_default' => $this->is_default,
            'is_active' => $this->is_active,

            'created_at' => $this->formatDate($this->created_at),
            'updated_at' => $this->formatDate($this->updated_at),
        ];
    }
}
