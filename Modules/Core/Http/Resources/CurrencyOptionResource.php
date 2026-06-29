<?php

declare(strict_types=1);

namespace Modules\Core\Http\Resources;

use App\Support\Http\Resources\BaseResource;
use Illuminate\Http\Request;
use Modules\Core\Models\Currency;

/**
 * @mixin Currency
 */
final class CurrencyOptionResource extends BaseResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'label' => $this->name,
            'value' => $this->id,
            'symbol' => $this->symbol,
            'currency_symbol' => $this->currency_symbol,
        ];
    }
}
