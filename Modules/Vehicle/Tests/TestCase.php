<?php

declare(strict_types=1);

namespace Modules\Vehicle\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Database\Seeders\CoreDatabaseSeeder;
use Modules\Core\Models\Country;
use Modules\IAM\Database\Seeders\IAMDatabaseSeeder;
use Modules\Tests\Traits\ApiAssertions;
use Modules\Vehicle\Database\Seeders\VehicleDatabaseSeeder;
use Modules\Vehicle\Models\Brand;
use Modules\Vehicle\Models\VehicleObdDevice;
use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use ApiAssertions;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CoreDatabaseSeeder::class);
        $this->seed(IAMDatabaseSeeder::class);
        $this->seed(VehicleDatabaseSeeder::class);
    }

    protected function apiHeaders(array $headers = []): array
    {
        return array_merge([
            'Accept' => 'application/json',
        ], $headers);
    }

    protected function validBrandData(array $overrides = []): array
    {
        $countryId = Country::query()->value('id');

        return array_merge([
            'name' => 'Nissan',
            'slug' => 'nissan',
            'logo' => null,
            'country_id' => $countryId,
            'is_active' => true,
        ], $overrides);
    }

    protected function validVehicleModelData(array $overrides = []): array
    {
        $brandId = Brand::query()->value('id');

        return array_merge([
            'brand_id' => $brandId,
            'name' => 'Altima',
            'slug' => 'nissan-altima',
            'is_active' => true,
        ], $overrides);
    }

    protected function validObdDeviceData(array $overrides = []): array
    {
        return array_merge([
            'serial_number' => 'OBD-123456789',
            'manufacturer' => 'Launch',
            'model' => 'X431',
            'firmware_version' => '1.0.0',
            'hardware_version' => '1.0',
            'connection_type' => 'bluetooth',
            'status' => 'active',
            'mac_address' => '00:11:22:33:44:55',
            'imei' => '123456789012345',
            'sim_number' => '01234567890123456789',
            'metadata' => [
                'battery' => 100,
            ],
        ], $overrides);
    }

    protected function validObdSessionData(array $overrides = []): array
    {
        $pairing = VehicleObdDevice::query()->firstOrFail();

        return array_merge([
            'vehicle_obd_device_id' => $pairing->id,
            'connection_type' => 'bluetooth',
            'status' => 'connecting',
            'started_at' => now()->toISOString(),
            'last_activity_at' => now()->toISOString(),
            'ip_address' => '192.168.1.10',
            'firmware_version' => '1.0.0',
            'metadata' => [],
        ], $overrides);
    }
}
