<?php

declare(strict_types=1);

namespace Modules\Vehicle\Database\Seeders\OBD;

use Illuminate\Database\Seeder;
use Modules\Vehicle\Models\ObdDevice;
use Modules\Vehicle\Models\Vehicle;
use Modules\Vehicle\Models\VehicleObdDevice;

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
