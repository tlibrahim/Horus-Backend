<?php

namespace Modules\Vehicle\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Vehicle\Models\ObdDevice;
use Modules\Vehicle\Models\Vehicle;
use Modules\Vehicle\Models\VehicleObdDevice;

class VehicleObdDeviceFactory extends Factory
{
    protected $model = VehicleObdDevice::class;

    public function definition(): array
    {
        return [
            'vehicle_id' => Vehicle::factory(),
            'obd_device_id' => ObdDevice::factory(),
            'paired_at' => now(),
            'unpaired_at' => null,
            'is_active' => true,
            'notes' => fake()->optional()->sentence(),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn () => [
            'is_active' => false,
            'unpaired_at' => now(),
        ]);
    }
}
