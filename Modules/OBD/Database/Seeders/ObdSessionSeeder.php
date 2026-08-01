<?php

declare(strict_types=1);

namespace Modules\OBD\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\OBD\Models\ObdSession;
use Modules\OBD\Models\VehicleObdDevice;

final class ObdSessionSeeder extends Seeder
{
    public function run(): void
    {
        VehicleObdDevice::query()
            ->get()
            ->each(function (VehicleObdDevice $pairing): void {
                ObdSession::factory()->create([
                    'vehicle_obd_device_id' => $pairing->id,
                ]);
            });
    }
}
