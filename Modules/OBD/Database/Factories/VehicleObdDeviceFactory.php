<?php

namespace Modules\OBD\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\OBD\Models\ObdDevice;
use Modules\OBD\Models\VehicleObdDevice;
use Modules\Vehicle\Models\Vehicle;

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
