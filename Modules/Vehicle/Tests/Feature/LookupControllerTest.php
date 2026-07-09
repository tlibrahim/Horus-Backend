<?php

declare(strict_types=1);

namespace Modules\Vehicle\Tests\Feature;

use Modules\Vehicle\Models\BodyType;
use Modules\Vehicle\Models\DriveType;
use Modules\Vehicle\Models\FuelType;
use Modules\Vehicle\Models\Transmission;
use Modules\Vehicle\Models\VehicleType;
use Modules\Vehicle\Tests\TestCase;

final class LookupControllerTest extends TestCase
{
    public function test_it_can_list_fuel_types(): void
    {
        $response = $this->getJson(route('api.v1.vehicle.fuelTypes.index'), $this->apiHeaders());
        $this->assertPaginatedResponse($response);
    }

    public function test_it_can_show_fuel_type(): void
    {
        $model = FuelType::query()->firstOrFail();
        $response = $this->getJson(route('api.v1.vehicle.fuelTypes.show', $model), $this->apiHeaders());
        $this->assertSuccessResponse($response);
    }

    public function test_it_can_list_transmissions(): void
    {
        $response = $this->getJson(route('api.v1.vehicle.transmissions.index'), $this->apiHeaders());
        $this->assertPaginatedResponse($response);

        $model = Transmission::query()->firstOrFail();
        $this->getJson(route('api.v1.vehicle.transmissions.show', $model), $this->apiHeaders())->assertOk();
    }

    public function test_it_can_list_drive_types(): void
    {
        $response = $this->getJson(route('api.v1.vehicle.driveTypes.index'), $this->apiHeaders());
        $this->assertPaginatedResponse($response);

        $model = DriveType::query()->firstOrFail();
        $this->getJson(route('api.v1.vehicle.driveTypes.show', $model), $this->apiHeaders())->assertOk();
    }

    public function test_it_can_list_body_types(): void
    {
        $response = $this->getJson(route('api.v1.vehicle.bodyTypes.index'), $this->apiHeaders());
        $this->assertPaginatedResponse($response);

        $model = BodyType::query()->firstOrFail();
        $this->getJson(route('api.v1.vehicle.bodyTypes.show', $model), $this->apiHeaders())->assertOk();
    }

    public function test_it_can_list_vehicle_types(): void
    {
        $response = $this->getJson(route('api.v1.vehicle.vehicleTypes.index'), $this->apiHeaders());
        $this->assertPaginatedResponse($response);

        $model = VehicleType::query()->firstOrFail();
        $this->getJson(route('api.v1.vehicle.vehicleTypes.show', $model), $this->apiHeaders())->assertOk();
    }
}
