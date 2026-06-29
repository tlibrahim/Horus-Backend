<?php

namespace Modules\Core\Database\Seeders\Vehicle;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DriveTypeSeeder extends Seeder
{
    public function run(): void
    {
        $driveTypes = [
            [
                'name' => 'Front-Wheel Drive',
                'code' => 'FWD',
                'discription' => 'Engine power delivered to front wheels.',
                'is_active' => true,
            ],
            [
                'name' => 'Rear-Wheel Drive',
                'code' => 'RWD',
                'discription' => 'Engine power delivered to rear wheels.',
                'is_active' => true,
            ],
            [
                'name' => 'All-Wheel Drive',
                'code' => 'AWD',
                'discription' => 'Power delivered to all wheels.',
                'is_active' => true,
            ],
        ];

        foreach ($driveTypes as $driveType) {
            DB::table('drive_types')->updateOrInsert(
                ['code' => $driveType['code']],
                array_merge($driveType, ['updated_at' => now(), 'created_at' => now()])
            );
        }
    }
}
