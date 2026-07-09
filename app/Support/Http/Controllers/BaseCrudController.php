<?php

declare(strict_types=1);

namespace App\Support\Http\Controllers;

use App\Support\Http\Requests\BaseRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class BaseCrudController extends BaseApiController
{
    public function __construct(
        protected readonly object $service,
    ) {}

    /**
     * @return class-string
     */
    abstract protected function indexResource(): string;

    /**
     * @return class-string
     */
    abstract protected function detailResource(): string;

    /**
     * @return class-string
     */
    abstract protected function optionResource(): string;

    /**
     * @return class-string<BaseRequest>
     */
    abstract protected function storeRequest(): string;

    /**
     * @return class-string<BaseRequest>
     */
    abstract protected function updateRequest(): string;

    /**
     * @return class-string<BaseRequest>|null
     */
    protected function statusRequest(): ?string
    {
        return null;
    }

    protected function routeParameter(): string
    {
        return 'id';
    }

    public function index(): JsonResponse
    {
        return $this->paginated(
            paginator: $this->service->paginate(),
            resource: $this->indexResource(),
        );
    }

    public function options(): JsonResponse
    {
        $resource = $this->optionResource();

        return $this->success(
            data: $resource::collection(
                $this->service->options(),
            ),
        );
    }

    public function store(Request $request): JsonResponse
    {
        $payload = $this->validated($request, $this->storeRequest());
        $model = $this->service->create($payload);
        $resource = $this->detailResource();

        return $this->created(
            data: $resource::make($model),
        );
    }

    public function show(mixed $model = null): JsonResponse
    {
        $model = $this->resolvedModel($model);
        $resource = $this->detailResource();

        return $this->success(
            data: $resource::make($model),
        );
    }

    public function update(Request $request, mixed $model = null): JsonResponse
    {
        $model = $this->resolvedModel($model);
        $payload = $this->validated($request, $this->updateRequest());
        $model = $this->service->update($model, $payload);
        $resource = $this->detailResource();

        return $this->updated(
            data: $resource::make($model),
        );
    }

    public function toggleStatus(Request $request, mixed $model = null): JsonResponse
    {
        $statusRequestClass = $this->statusRequest();

        if ($statusRequestClass === null) {
            return $this->conflict(
                detail: 'Status updates are not supported for this resource.',
            );
        }

        $model = $this->resolvedModel($model);
        $payload = $this->validated($request, $statusRequestClass);

        $model = $this->service->toggleStatus(
            $model,
            (bool) ($payload['is_active'] ?? false),
        );

        $resource = $this->indexResource();

        return $this->updated(
            data: $resource::make($model),
        );
    }

    public function activate(mixed $model = null): JsonResponse
    {
        $model = $this->resolvedModel($model);

        if (method_exists($this->service, 'activate')) {
            $model = $this->service->activate($model);
        } else {
            $model = $this->service->toggleStatus($model, true);
        }

        $resource = $this->indexResource();

        return $this->updated(
            data: $resource::make($model),
        );
    }

    public function deactivate(mixed $model = null): JsonResponse
    {
        $model = $this->resolvedModel($model);

        if (method_exists($this->service, 'deactivate')) {
            $model = $this->service->deactivate($model);
        } else {
            $model = $this->service->toggleStatus($model, false);
        }

        $resource = $this->indexResource();

        return $this->updated(
            data: $resource::make($model),
        );
    }

    public function destroy(mixed $model = null): JsonResponse
    {
        $model = $this->resolvedModel($model);

        $this->service->delete($model);

        return $this->deleted();
    }

    protected function resolvedModel(mixed $model = null): mixed
    {
        $value = $model ?? request()->route($this->routeParameter());

        if (is_object($value)) {
            return $value;
        }

        if (! is_scalar($value)) {
            abort(404);
        }

        return $this->service->find((string) $value);
    }

    /**
     * @param  class-string<BaseRequest>  $requestClass
     */
    protected function validated(Request $request, string $requestClass): array
    {
        /** @var BaseRequest $formRequest */
        $formRequest = $requestClass::createFrom($request);

        $formRequest->setContainer(app());
        $formRequest->setRedirector(app('redirect'));
        $formRequest->setRouteResolver($request->getRouteResolver());
        $formRequest->validateResolved();

        return $formRequest->validated();
    }
}
