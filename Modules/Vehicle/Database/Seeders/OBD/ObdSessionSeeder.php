<?php

declare(strict_types=1);

namespace Modules\Vehicle\Database\Seeders\OBD;

use Illuminate\Database\Seeder;
use Modules\Vehicle\Models\ObdSession;
use Modules\Vehicle\Models\VehicleObdDevice;

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
