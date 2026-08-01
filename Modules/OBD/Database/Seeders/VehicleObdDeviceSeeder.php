<?php

declare(strict_types=1);

namespace Modules\OBD\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\OBD\Models\ObdDevice;
use Modules\OBD\Models\VehicleObdDevice;
use Modules\Vehicle\Models\Vehicle;

final class VehicleObdDeviceSeeder extends Seeder
{
    public function run(): void
    {
        $vehicles = Vehicle::all();

        foreach ($vehicles as $vehicle) {

            $device = ObdDevice::query()
                ->inRandomOrder()
                ->first();

            if ($device === null) {
                $device = ObdDevice::factory()->create();
            }

            VehicleObdDevice::factory()->create([
                'vehicle_id' => $vehicle->id,
                'obd_device_id' => $device->id,
                'paired_at' => now(),
                'is_active' => true,
                'notes' => 'Seeded pairing',
            ]);
        }
    }
}
