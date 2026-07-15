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
}
