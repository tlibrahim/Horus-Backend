<?php

namespace Modules\Core\Database\Seeders\Vehicle;

use Illuminate\Database\Seeder;
use Modules\Core\Models\VehicleMakeModel;
use Modules\Core\Models\VehicleMakeModelGeneration;

class VehicleMakeModelGenerationSeeder extends Seeder
{
    public function run(): void
    {
        $modelsByName = VehicleMakeModel::whereIn('name', ['Nile 1', 'Desert X', 'Falcon S'])
            ->pluck('id', 'name');

        $generations = [
            [
                'name' => 'Gen 1',
                'code' => 'NILE1-G1',
                'vehicle_make_model_id' => $modelsByName['Nile 1'] ?? null,
                'start_date' => '2020-01-01',
                'end_date' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Gen 1',
                'code' => 'DESERTX-G1',
                'vehicle_make_model_id' => $modelsByName['Desert X'] ?? null,
                'start_date' => '2021-01-01',
                'end_date' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Gen 1',
                'code' => 'FALCONS-G1',
                'vehicle_make_model_id' => $modelsByName['Falcon S'] ?? null,
                'start_date' => '2022-01-01',
                'end_date' => null,
                'is_active' => true,
            ],
        ];

        foreach ($generations as $generation) {
            VehicleMakeModelGeneration::updateOrCreate(
                ['vehicle_make_model_id' => $generation['vehicle_make_model_id'], 'name' => $generation['name']],
                $generation
            );
        }
    }
}
