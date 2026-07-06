<?php

namespace Modules\Core\Database\Seeders\Vehicle;

use Illuminate\Database\Seeder;
use Modules\Core\Models\TransmissionType;

class TransmissionTypeSeeder extends Seeder
{
    public function run(): void
    {
        $transmissionTypes = [
            [
                'name' => 'Manual',
                'code' => 'MT',
                'discription' => 'Manual transmission with clutch pedal.',
                'is_active' => true,
            ],
            [
                'name' => 'Automatic',
                'code' => 'AT',
                'discription' => 'Automatic transmission with torque converter.',
                'is_active' => true,
            ],
            [
                'name' => 'CVT',
                'code' => 'CVT',
                'discription' => 'Continuously variable transmission.',
                'is_active' => true,
            ],
        ];

        foreach ($transmissionTypes as $transmissionType) {
            TransmissionType::updateOrCreate(
                ['code' => $transmissionType['code']],
                $transmissionType
            );
        }
    }
}
