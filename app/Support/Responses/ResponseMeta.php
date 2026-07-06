<?php

declare(strict_types=1);

namespace App\Support\Responses;

use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

final readonly class ResponseMeta
{
    public static function make(?Request $request = null): array
    {
        $request ??= request();

        return [
            'request_id' => self::requestId($request),
            'timestamp' => CarbonImmutable::now('UTC')->toIso8601String(),
            'locale' => App::currentLocale(),
            'timezone' => config('app.timezone'),
            'api_version' => config('app.api_version', 'v1'),
        ];
    }

    private static function requestId(Request $request): string
    {
        return (string) $request->attributes->get(
            'request_id',
            $request->header('X-Request-ID', ''),
        );
    }
}
