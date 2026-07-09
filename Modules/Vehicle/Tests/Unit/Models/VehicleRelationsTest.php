<?php

declare(strict_types=1);

namespace Modules\Vehicle\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Vehicle\Models\Brand;
use Modules\Vehicle\Models\Engine;
use Modules\Vehicle\Models\Generation;
use Modules\Vehicle\Models\VehicleModel;
use Modules\Vehicle\Tests\TestCase;

final class VehicleRelationsTest extends TestCase
{
    public function test_brand_has_many_models_relation(): void
    {
        $brand = new Brand;

        $this->assertInstanceOf(HasMany::class, $brand->models());
    }

    public function test_vehicle_model_belongs_to_brand_relation(): void
    {
        $vehicleModel = new VehicleModel;

        $this->assertInstanceOf(BelongsTo::class, $vehicleModel->brand());
    }

    public function test_vehicle_model_has_many_generations_relation(): void
    {
        $vehicleModel = new VehicleModel;

        $this->assertInstanceOf(HasMany::class, $vehicleModel->generations());
    }

    public function test_generation_belongs_to_model_relation(): void
    {
        $generation = new Generation;

        $this->assertInstanceOf(BelongsTo::class, $generation->model());
    }

    public function test_generation_has_many_engines_relation(): void
    {
        $generation = new Generation;

        $this->assertInstanceOf(HasMany::class, $generation->engines());
    }

    public function test_engine_belongs_to_generation_relation(): void
    {
        $engine = new Engine;

        $this->assertInstanceOf(BelongsTo::class, $engine->generation());
    }
}
