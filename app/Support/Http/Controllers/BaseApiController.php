<?php

declare(strict_types=1);

namespace App\Support\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Support\Enums\ProblemType;
use App\Support\Responses\ApiResponse;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Pagination\CursorPaginator;

/**
 * Base controller for API endpoints.
 */
abstract class BaseApiController extends Controller
{
    protected function success(
        mixed $data = null,
        ?string $message = null,
        int $status = Response::HTTP_OK,
        array $meta = [],
        array $headers = [],
    ): JsonResponse {
        return ApiResponse::success(
            data: $data,
            message: $message,
            status: $status,
            meta: $meta,
            headers: $headers,
        );
    }

    protected function created(
        mixed $data = null,
        ?string $message = null,
        array $meta = [],
        array $headers = [],
    ): JsonResponse {
        return ApiResponse::created(
            data: $data,
            message: $message,
            meta: $meta,
            headers: $headers,
        );
    }

    protected function accepted(
        mixed $data = null,
        ?string $message = null,
        array $meta = [],
        array $headers = [],
    ): JsonResponse {
        return ApiResponse::accepted(
            data: $data,
            message: $message,
            meta: $meta,
            headers: $headers,
        );
    }

    protected function updated(
        mixed $data = null,
        ?string $message = null,
        array $meta = [],
        array $headers = [],
    ): JsonResponse {
        return ApiResponse::updated(
            data: $data,
            message: $message,
            meta: $meta,
            headers: $headers,
        );
    }

    protected function deleted(
        ?string $message = null,
        array $meta = [],
        array $headers = [],
    ): JsonResponse {
        return ApiResponse::deleted(
            message: $message,
            meta: $meta,
            headers: $headers,
        );
    }

    protected function noContent(array $headers = []): Response
    {
        return ApiResponse::noContent(headers: $headers);
    }

    /**
     * Return a paginated response.
     *
     * @param  class-string<JsonResource>  $resource
     */
    protected function paginated(
        AbstractPaginator|CursorPaginator $paginator,
        string $resource,
        ?string $message = null,
        array $meta = [],
        array $headers = [],
    ): JsonResponse {
        return ApiResponse::paginated(
            paginator: $paginator->through(
                fn ($model) => $resource::make($model),
            ),
            message: $message,
            meta: $meta,
            headers: $headers,
        );
    }

    protected function validation(
        array $errors,
        ?string $detail = null,
        array $meta = [],
        array $headers = [],
    ): JsonResponse {
        return $this->problem(
            type: ProblemType::Validation,
            detail: $detail ?? __('api.errors.validation.detail'),
            status: Response::HTTP_UNPROCESSABLE_ENTITY,
            errors: $errors,
            meta: $meta,
            headers: $headers,
        );
    }

    protected function unauthorized(
        ?string $detail = null,
        array $meta = [],
        array $headers = [],
    ): JsonResponse {
        return $this->problem(
            type: ProblemType::Unauthorized,
            detail: $detail ?? __('api.errors.unauthorized.detail'),
            status: Response::HTTP_UNAUTHORIZED,
            meta: $meta,
            headers: $headers,
        );
    }

    protected function forbidden(
        ?string $detail = null,
        array $meta = [],
        array $headers = [],
    ): JsonResponse {
        return $this->problem(
            type: ProblemType::Forbidden,
            detail: $detail ?? __('api.errors.forbidden.detail'),
            status: Response::HTTP_FORBIDDEN,
            meta: $meta,
            headers: $headers,
        );
    }

    protected function notFound(
        ?string $detail = null,
        array $meta = [],
        array $headers = [],
    ): JsonResponse {
        return $this->problem(
            type: ProblemType::NotFound,
            detail: $detail ?? __('api.errors.not_found.detail'),
            status: Response::HTTP_NOT_FOUND,
            meta: $meta,
            headers: $headers,
        );
    }

    protected function conflict(
        ?string $detail = null,
        array $meta = [],
        array $headers = [],
    ): JsonResponse {
        return $this->problem(
            type: ProblemType::Conflict,
            detail: $detail ?? __('api.errors.conflict.detail'),
            status: Response::HTTP_CONFLICT,
            meta: $meta,
            headers: $headers,
        );
    }

    protected function serverError(
        ?string $detail = null,
        array $meta = [],
        array $headers = [],
    ): JsonResponse {
        return $this->problem(
            type: ProblemType::InternalServerError,
            detail: $detail ?? __('api.errors.internal_server_error.detail'),
            status: Response::HTTP_INTERNAL_SERVER_ERROR,
            meta: $meta,
            headers: $headers,
        );
    }

    protected function user(): ?Authenticatable
    {
        return auth()->user();
    }

    protected function userId(): int|string|null
    {
        return auth()->id();
    }

    protected function isAuthenticated(): bool
    {
        return auth()->check();
    }

    private function problem(
        ProblemType|string $type,
        string $detail,
        int $status,
        ?string $title = null,
        ?string $instance = null,
        array $errors = [],
        array $meta = [],
        array $headers = [],
    ): JsonResponse {
        return ApiResponse::error(
            type: $type,
            detail: $detail,
            status: $status,
            title: $title,
            instance: $instance,
            errors: $errors,
            meta: $meta,
            headers: $headers,
        );
    }
}
