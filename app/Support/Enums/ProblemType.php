<?php

declare(strict_types=1);

namespace App\Support\Enums;

/**
 * RFC 7807 Problem Type URIs.
 */
enum ProblemType: string
{
    case Validation = '/problems/validation';
    case Unauthorized = '/problems/unauthorized';
    case Forbidden = '/problems/forbidden';
    case NotFound = '/problems/not-found';
    case Conflict = '/problems/conflict';
    case TooManyRequests = '/problems/too-many-requests';
    case UnsupportedMediaType = '/problems/unsupported-media-type';
    case UnprocessableEntity = '/problems/unprocessable-entity';
    case InternalServerError = '/problems/internal-server-error';
    case ServiceUnavailable = '/problems/service-unavailable';

    public function uri(): string
    {
        return sprintf(
            '%s%s',
            rtrim((string) config('app.url', ''), '/'),
            $this->value
        );
    }

    public function title(): string
    {
        return match ($this) {
            self::Validation => __('api.errors.validation.title'),
            self::Unauthorized => __('api.errors.unauthorized.title'),
            self::Forbidden => __('api.errors.forbidden.title'),
            self::NotFound => __('api.errors.not_found.title'),
            self::Conflict => __('api.errors.conflict.title'),
            self::TooManyRequests => __('api.errors.too_many_requests.title'),
            self::UnsupportedMediaType => __('api.errors.unsupported_media_type.title'),
            self::UnprocessableEntity => __('api.errors.unprocessable_entity.title'),
            self::InternalServerError => __('api.errors.internal_server_error.title'),
            self::ServiceUnavailable => __('api.errors.service_unavailable.title'),
        };
    }
}
