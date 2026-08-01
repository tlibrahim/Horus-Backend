<?php

declare(strict_types=1);

namespace Modules\Auth\Http\Requests\Auth;

use App\Support\Http\Requests\BaseRequest;

final class RefreshRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'refresh_token' => ['required', 'uuid'],
        ];
    }
}
