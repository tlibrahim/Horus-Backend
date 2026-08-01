<?php

declare(strict_types=1);

namespace Modules\OBD\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\OBD\Enums\ConnectionType;
use Modules\OBD\Enums\ObdDeviceStatus;
use Modules\OBD\Models\ObdDevice;

final class ObdDeviceSeeder extends Seeder
{
    public function run(): void
    {
        collect([
            [
                'connection_type' => ConnectionType::Bluetooth,
                'status' => ObdDeviceStatus::Active,
            ],
            [
                'connection_type' => ConnectionType::Wifi,
                'status' => ObdDeviceStatus::Active,
            ],
            [
                'connection_type' => ConnectionType::Bluetooth,
                'status' => ObdDeviceStatus::Inactive,
            ],
            [
                'connection_type' => ConnectionType::Gsm,
                'status' => ObdDeviceStatus::Active,
            ],
            [
                'connection_type' => ConnectionType::Usb,
                'status' => ObdDeviceStatus::Active,
            ],
        ])->each(function (array $attributes): void {
            ObdDevice::factory()->create($attributes);
        });

        // Additional random devices
        ObdDevice::factory()->count(5)->create();
    }
}
