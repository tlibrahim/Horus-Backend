<?php

namespace Modules\Vehicle\Database\Seeders\Vehicle;

use Illuminate\Database\Seeder;
use Modules\IAM\Models\User;
use Modules\Vehicle\Models\BodyType;
use Modules\Vehicle\Models\Brand;
use Modules\Vehicle\Models\DriveType;
use Modules\Vehicle\Models\Engine;
use Modules\Vehicle\Models\Generation;
use Modules\Vehicle\Models\Vehicle;
use Modules\Vehicle\Models\VehicleModel;
use Modules\Vehicle\Models\VehicleType;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        $brand = Brand::where('id', 2)->first();

        $model = VehicleModel::where('brand_id', $brand->id)
            ->inRandomOrder()
            ->first();

        $generation = Generation::where('model_id', $model->id)
            ->inRandomOrder()
            ->first();

        $engine = Engine::where('generation_id', $generation->id)
            ->first();

        Vehicle::create([

            'user_id' => $user->id,

            'brand_id' => $brand->id,

            'model_id' => $model->id,

            'generation_id' => $generation->id,

            'engine_id' => $engine->id,

            'body_type_id' => BodyType::inRandomOrder()->value('id'),

            'drive_type_id' => DriveType::inRandomOrder()->value('id'),

            'vehicle_type_id' => VehicleType::inRandomOrder()->value('id'),

            'vin' => $this->generateVin(),

            'plate_number' => fake()->bothify('??-####'),

            'manufacture_year' => fake()->numberBetween(2018, 2025),

            'current_mileage' => fake()->numberBetween(5_000, 180_000),

            'color' => fake()->randomElement([
                'White',
                'Black',
                'Silver',
                'Gray',
                'Blue',
                'Red',
            ]),

            'is_primary' => true,
        ]);
    }

    private function generateVin(): string
    {
        $characters = 'ABCDEFGHJKLMNPRSTUVWXYZ0123456789';

        return collect(range(1, 17))
            ->map(fn () => $characters[random_int(0, strlen($characters) - 1)])
            ->implode('');
    }
}
