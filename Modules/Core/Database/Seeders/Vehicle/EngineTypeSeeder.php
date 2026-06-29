<?php

namespace Modules\Core\Database\Seeders\Vehicle;

use Illuminate\Database\Seeder;
use Modules\Core\Models\EngineType;

class EngineTypeSeeder extends Seeder
{
    public function run(): void
    {
        $engineTypes = [
            [
                'name' => 'Internal Combustion Engine',
                'code' => 'ICE',
                'discription' => 'Traditional petrol or diesel combustion engine.',
                'is_active' => true,
            ],
            [
                'name' => 'Hybrid Engine',
                'code' => 'HYBRID',
                'discription' => 'Combination of combustion and electric power.',
                'is_active' => true,
            ],
            [
                'name' => 'Electric Motor',
                'code' => 'EV',
                'discription' => 'Fully electric propulsion system.',
                'is_active' => true,
            ],
        ];

        foreach ($engineTypes as $engineType) {
            EngineType::updateOrCreate(
                ['code' => $engineType['code']],
                $engineType
            );
        }
    }
}
