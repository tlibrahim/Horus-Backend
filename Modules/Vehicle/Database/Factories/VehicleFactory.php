<?php

declare(strict_types=1);

namespace Modules\Vehicle\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Vehicle\Models\BodyType;
use Modules\Vehicle\Models\Brand;
use Modules\Vehicle\Models\DriveType;
use Modules\Vehicle\Models\Engine;
use Modules\Vehicle\Models\Generation;
use Modules\Vehicle\Models\Vehicle;
use Modules\Vehicle\Models\VehicleModel;
use Modules\Vehicle\Models\VehicleType;

final class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    public function definition(): array
    {
        return [
            'user_id' => 1,

            'brand_id' => Brand::query()->value('id') ?? 1,
            'model_id' => VehicleModel::query()->value('id') ?? 1,
            'generation_id' => Generation::query()->value('id') ?? 1,
            'engine_id' => Engine::query()->value('id') ?? 1,

            'body_type_id' => BodyType::query()->value('id') ?? 1,
            'drive_type_id' => DriveType::query()->value('id') ?? 1,
            'vehicle_type_id' => VehicleType::query()->value('id') ?? 1,

            'vin' => fake()->unique()->regexify('[A-HJ-NPR-Z0-9]{17}'),
            'plate_number' => fake()->bothify('???-####'),

            'manufacture_year' => fake()->numberBetween(2018, now()->year),

            'current_mileage' => fake()->numberBetween(0, 250000),

            'color' => fake()->safeColorName(),

            'is_primary' => false,
        ];
    }
}
