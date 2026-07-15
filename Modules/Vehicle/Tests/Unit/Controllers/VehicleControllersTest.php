<?php

declare(strict_types=1);

namespace Modules\Vehicle\Tests\Unit\Controllers;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use Modules\Vehicle\Contracts\BodyType\BodyTypeServiceInterface;
use Modules\Vehicle\Contracts\Brand\BrandServiceInterface;
use Modules\Vehicle\Contracts\DriveType\DriveTypeServiceInterface;
use Modules\Vehicle\Contracts\Engine\EngineServiceInterface;
use Modules\Vehicle\Contracts\FuelType\FuelTypeServiceInterface;
use Modules\Vehicle\Contracts\Generation\GenerationServiceInterface;
use Modules\Vehicle\Contracts\Transmission\TransmissionServiceInterface;
use Modules\Vehicle\Contracts\VehicleModel\VehicleModelServiceInterface;
use Modules\Vehicle\Contracts\VehicleType\VehicleTypeServiceInterface;
use Modules\Vehicle\Http\Controllers\Api\Catalog\BodyTypeController;
use Modules\Vehicle\Http\Controllers\Api\Catalog\BrandController;
use Modules\Vehicle\Http\Controllers\Api\Catalog\DriveTypeController;
use Modules\Vehicle\Http\Controllers\Api\Catalog\EngineController;
use Modules\Vehicle\Http\Controllers\Api\Catalog\FuelTypeController;
use Modules\Vehicle\Http\Controllers\Api\Catalog\GenerationController;
use Modules\Vehicle\Http\Controllers\Api\Catalog\TransmissionController;
use Modules\Vehicle\Http\Controllers\Api\Catalog\VehicleModelController;
use Modules\Vehicle\Http\Controllers\Api\Catalog\VehicleTypeController;
use Modules\Vehicle\Models\BodyType;
use Modules\Vehicle\Models\Brand;
use Modules\Vehicle\Models\DriveType;
use Modules\Vehicle\Models\Engine;
use Modules\Vehicle\Models\FuelType;
use Modules\Vehicle\Models\Generation;
use Modules\Vehicle\Models\Transmission;
use Modules\Vehicle\Models\VehicleModel;
use Modules\Vehicle\Models\VehicleType;
use Modules\Vehicle\Tests\TestCase;

final class VehicleControllersTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_brand_controller_actions_return_success_responses(): void
    {
        $brand = new Brand(['id' => 1, 'name' => 'Toyota', 'slug' => 'toyota', 'is_active' => true]);

        $service = Mockery::mock(BrandServiceInterface::class);
        $service->shouldReceive('paginate')->once()->andReturn($this->paginator([$brand]));
        $service->shouldReceive('options')->once()->andReturn($this->eloquentCollection([$brand]));
        $service->shouldReceive('delete')->once()->andReturn(true);

        $controller = new BrandController($service);

        $this->assertSuccess($controller->index());
        $this->assertSuccess($controller->options());
        $this->assertSuccess($controller->show($brand));

        $this->assertSuccess($controller->destroy($brand));
    }

    public function test_vehicle_model_controller_actions_return_success_responses(): void
    {
        $model = new VehicleModel(['id' => 1, 'brand_id' => 1, 'name' => 'Corolla', 'slug' => 'corolla', 'is_active' => true]);

        $service = Mockery::mock(VehicleModelServiceInterface::class);
        $service->shouldReceive('paginate')->once()->andReturn($this->paginator([$model]));
        $service->shouldReceive('options')->once()->andReturn($this->eloquentCollection([$model]));
        $service->shouldReceive('delete')->once()->andReturn(true);

        $controller = new VehicleModelController($service);

        $this->assertSuccess($controller->index());
        $this->assertSuccess($controller->options());
        $this->assertSuccess($controller->show($model));

        $this->assertSuccess($controller->destroy($model));
    }

    public function test_generation_and_engine_controllers_actions_return_success_responses(): void
    {
        $generation = new Generation(['id' => 1, 'model_id' => 1, 'name' => 'E210', 'is_active' => true]);
        $engine = new Engine(['id' => 1, 'generation_id' => 1, 'code' => 'M20A', 'name' => '2.0L', 'is_active' => true]);

        $generationService = Mockery::mock(GenerationServiceInterface::class);
        $generationService->shouldReceive('paginate')->once()->andReturn($this->paginator([$generation]));
        $generationService->shouldReceive('options')->once()->andReturn($this->eloquentCollection([$generation]));
        $generationService->shouldReceive('delete')->once()->andReturn(true);

        $engineService = Mockery::mock(EngineServiceInterface::class);
        $engineService->shouldReceive('paginate')->once()->andReturn($this->paginator([$engine]));
        $engineService->shouldReceive('options')->once()->andReturn($this->eloquentCollection([$engine]));
        $engineService->shouldReceive('delete')->once()->andReturn(true);

        $generationController = new GenerationController($generationService);
        $engineController = new EngineController($engineService);

        $this->assertSuccess($generationController->index());
        $this->assertSuccess($generationController->options());
        $this->assertSuccess($generationController->show($generation));

        $this->assertSuccess($generationController->destroy($generation));

        $this->assertSuccess($engineController->index());
        $this->assertSuccess($engineController->options());
        $this->assertSuccess($engineController->show($engine));

        $this->assertSuccess($engineController->destroy($engine));
    }

    public function test_lookup_controllers_actions_return_success_responses(): void
    {
        $fuelType = new FuelType(['id' => 1, 'name' => 'Gasoline', 'slug' => 'gasoline']);
        $transmission = new Transmission(['id' => 1, 'name' => 'Automatic', 'slug' => 'automatic']);
        $driveType = new DriveType(['id' => 1, 'name' => 'AWD', 'slug' => 'awd']);
        $bodyType = new BodyType(['id' => 1, 'name' => 'SUV', 'slug' => 'suv']);
        $vehicleType = new VehicleType(['id' => 1, 'name' => 'Passenger', 'slug' => 'passenger']);

        $fuelService = Mockery::mock(FuelTypeServiceInterface::class);
        $fuelService->shouldReceive('paginate')->once()->andReturn($this->paginator([$fuelType]));
        $fuelService->shouldReceive('options')->once()->andReturn($this->eloquentCollection([$fuelType]));

        $transmissionService = Mockery::mock(TransmissionServiceInterface::class);
        $transmissionService->shouldReceive('paginate')->once()->andReturn($this->paginator([$transmission]));
        $transmissionService->shouldReceive('options')->once()->andReturn($this->eloquentCollection([$transmission]));

        $driveService = Mockery::mock(DriveTypeServiceInterface::class);
        $driveService->shouldReceive('paginate')->once()->andReturn($this->paginator([$driveType]));
        $driveService->shouldReceive('options')->once()->andReturn($this->eloquentCollection([$driveType]));

        $bodyService = Mockery::mock(BodyTypeServiceInterface::class);
        $bodyService->shouldReceive('paginate')->once()->andReturn($this->paginator([$bodyType]));
        $bodyService->shouldReceive('options')->once()->andReturn($this->eloquentCollection([$bodyType]));

        $vehicleTypeService = Mockery::mock(VehicleTypeServiceInterface::class);
        $vehicleTypeService->shouldReceive('paginate')->once()->andReturn($this->paginator([$vehicleType]));
        $vehicleTypeService->shouldReceive('options')->once()->andReturn($this->eloquentCollection([$vehicleType]));

        $fuelController = new FuelTypeController($fuelService);
        $transmissionController = new TransmissionController($transmissionService);
        $driveController = new DriveTypeController($driveService);
        $bodyController = new BodyTypeController($bodyService);
        $vehicleTypeController = new VehicleTypeController($vehicleTypeService);

        $this->assertSuccess($fuelController->index());
        $this->assertSuccess($fuelController->options());
        $this->assertSuccess($fuelController->show($fuelType));

        $this->assertSuccess($transmissionController->index());
        $this->assertSuccess($transmissionController->options());
        $this->assertSuccess($transmissionController->show($transmission));

        $this->assertSuccess($driveController->index());
        $this->assertSuccess($driveController->options());
        $this->assertSuccess($driveController->show($driveType));

        $this->assertSuccess($bodyController->index());
        $this->assertSuccess($bodyController->options());
        $this->assertSuccess($bodyController->show($bodyType));

        $this->assertSuccess($vehicleTypeController->index());
        $this->assertSuccess($vehicleTypeController->options());
        $this->assertSuccess($vehicleTypeController->show($vehicleType));
    }

    private function paginator(array $items): LengthAwarePaginator
    {
        return new LengthAwarePaginator($items, count($items), 15);
    }

    private function eloquentCollection(array $items): EloquentCollection
    {
        return new EloquentCollection($items);
    }

    private function assertSuccess(JsonResponse $response, int $status = 200): void
    {
        $this->assertSame($status, $response->getStatusCode());

        $payload = $response->getData(true);

        $this->assertTrue($payload['success']);
        $this->assertArrayHasKey('meta', $payload);
    }
}
