<?php

declare(strict_types=1);

namespace App\Support\Responses;

use App\Support\Enums\ProblemType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Pagination\CursorPaginator;

final class ApiResponse
{
    public static function success(
        mixed $data = null,
        ?string $message = null,
        int $status = Response::HTTP_OK,
        array $meta = [],
        array $headers = [],
    ): JsonResponse {
        return self::json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            'meta' => self::meta($meta),
        ], $status, $headers);
    }

    public static function created(
        mixed $data = null,
        ?string $message = null,
        array $meta = [],
        array $headers = [],
    ): JsonResponse {
        return self::success(
            data: $data,
            message: $message ?? __('api.responses.created'),
            status: Response::HTTP_CREATED,
            meta: $meta,
            headers: $headers,
        );
    }

    public static function accepted(
        mixed $data = null,
        ?string $message = null,
        array $meta = [],
        array $headers = [],
    ): JsonResponse {
        return self::success(
            data: $data,
            message: $message ?? __('api.responses.accepted'),
            status: Response::HTTP_ACCEPTED,
            meta: $meta,
            headers: $headers,
        );
    }

    public static function updated(
        mixed $data = null,
        ?string $message = null,
        array $meta = [],
        array $headers = [],
    ): JsonResponse {
        return self::success(
            data: $data,
            message: $message ?? __('api.responses.updated'),
            status: Response::HTTP_OK,
            meta: $meta,
            headers: $headers,
        );
    }

    public static function deleted(
        ?string $message = null,
        array $meta = [],
        array $headers = [],
    ): JsonResponse {
        return self::success(
            data: null,
            message: $message ?? __('api.responses.deleted'),
            status: Response::HTTP_OK,
            meta: $meta,
            headers: $headers,
        );
    }

    public static function noContent(array $headers = []): Response
    {
        return response()->noContent(headers: $headers);
    }

    public static function paginated(
        AbstractPaginator|CursorPaginator $paginator,
        ?string $message = null,
        array $meta = [],
        array $headers = [],
    ): JsonResponse {
        return self::success(
            data: $paginator->items(),
            message: $message,
            meta: array_replace_recursive(
                ['pagination' => self::paginationMeta($paginator)],
                $meta,
            ),
            headers: $headers,
        );
    }

    public static function error(
        ProblemType|string $type,
        string $detail,
        int $status,
        ?string $title = null,
        ?string $instance = null,
        array $errors = [],
        array $meta = [],
        array $headers = [],
    ): JsonResponse {
        $problemType = $type instanceof ProblemType ? $type : null;

        $payload = [
            'success' => false,
            'error' => [
                'type' => $problemType?->uri() ?? (string) $type,
                'title' => $title ?? $problemType?->title() ?? Response::$statusTexts[$status] ?? 'Error',
                'status' => $status,
                'detail' => $detail,
                'instance' => $instance ?? request()->fullUrl(),
            ],
            'meta' => self::meta($meta),
        ];

        if ($errors !== []) {
            $payload['error']['errors'] = $errors;
        }

        return self::json($payload, $status, $headers);
    }

    private static function meta(array $meta): array
    {
        return [...ResponseMeta::make(), ...$meta];
    }

    private static function paginationMeta(AbstractPaginator|CursorPaginator $paginator): array
    {
        if ($paginator instanceof CursorPaginator) {
            return [
                'type' => 'cursor',
                'per_page' => $paginator->perPage(),
                'has_more_pages' => $paginator->hasMorePages(),
                'next_cursor' => $paginator->nextCursor()?->encode(),
                'prev_cursor' => $paginator->previousCursor()?->encode(),
                'path' => $paginator->path(),
            ];
        }

        return [
            'type' => 'length_aware',
            'current_page' => $paginator->currentPage(),
            'last_page' => method_exists($paginator, 'lastPage') ? $paginator->lastPage() : null,
            'per_page' => $paginator->perPage(),
            'total' => method_exists($paginator, 'total') ? $paginator->total() : null,
            'from' => $paginator->firstItem(),
            'to' => $paginator->lastItem(),
            'path' => $paginator->path(),
        ];
    }

    private static function json(array $payload, int $status, array $headers = []): JsonResponse
    {
        return response()->json(
            data: $payload,
            status: $status,
            headers: $headers,
            options: JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES,
        );
    }
}
