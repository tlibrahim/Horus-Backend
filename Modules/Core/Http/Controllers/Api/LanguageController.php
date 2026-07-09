<?php

declare(strict_types=1);

namespace Modules\Core\Http\Controllers\Api;

use App\Support\Http\Controllers\BaseCrudController;
use Modules\Core\Contracts\LanguageServiceInterface;
use Modules\Core\Http\Requests\StoreLanguageRequest;
use Modules\Core\Http\Requests\UpdateLanguageRequest;
use Modules\Core\Http\Requests\UpdateLanguageStatusRequest;
use Modules\Core\Http\Resources\LanguageDetailsResource;
use Modules\Core\Http\Resources\LanguageOptionResource;
use Modules\Core\Http\Resources\LanguageResource;

final class LanguageController extends BaseCrudController
{
    public function __construct(
        LanguageServiceInterface $service,
    ) {
        parent::__construct($service);
    }

    protected function indexResource(): string
    {
        return LanguageResource::class;
    }

    protected function detailResource(): string
    {
        return LanguageDetailsResource::class;
    }

    protected function optionResource(): string
    {
        return LanguageOptionResource::class;
    }

    protected function storeRequest(): string
    {
        return StoreLanguageRequest::class;
    }

    protected function updateRequest(): string
    {
        return UpdateLanguageRequest::class;
    }

    protected function statusRequest(): ?string
    {
        return UpdateLanguageStatusRequest::class;
    }

    protected function routeParameter(): string
    {
        return 'language';
    }
}
