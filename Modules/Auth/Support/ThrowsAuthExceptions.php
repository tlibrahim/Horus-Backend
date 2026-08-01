<?php

declare(strict_types=1);

namespace Modules\Auth\Support;

use App\Support\Enums\ProblemType;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response;

trait ThrowsAuthExceptions
{
    private function unauthorized(string $detail): never
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'error' => [
                    'type' => ProblemType::Unauthorized->uri(),
                    'title' => ProblemType::Unauthorized->title(),
                    'status' => Response::HTTP_UNAUTHORIZED,
                    'detail' => $detail,
                ],
                'meta' => [],
            ], Response::HTTP_UNAUTHORIZED)
        );
    }

    private function forbidden(string $detail): never
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'error' => [
                    'type' => ProblemType::Forbidden->uri(),
                    'title' => ProblemType::Forbidden->title(),
                    'status' => Response::HTTP_FORBIDDEN,
                    'detail' => $detail,
                ],
                'meta' => [],
            ], Response::HTTP_FORBIDDEN)
        );
    }

    private function tooManyRequests(string $detail): never
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'error' => [
                    'type' => ProblemType::TooManyRequests->uri(),
                    'title' => ProblemType::TooManyRequests->title(),
                    'status' => Response::HTTP_TOO_MANY_REQUESTS,
                    'detail' => $detail,
                ],
                'meta' => [],
            ], Response::HTTP_TOO_MANY_REQUESTS)
        );
    }
}
