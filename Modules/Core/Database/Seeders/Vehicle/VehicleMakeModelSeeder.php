<?php

namespace Modules\Core\Database\Seeders\Vehicle;

use Illuminate\Database\Seeder;
use Modules\Core\Models\VehicleMake;
use Modules\Core\Models\VehicleMakeModel;

class VehicleMakeModelSeeder extends Seeder
{
    public function run(): void
    {
        $makesByName = VehicleMake::whereIn('name', ['Egypt Auto', 'Saudi Motors', 'Emirates Mobility'])
            ->pluck('id', 'name');

        $models = [
            [
                'name' => 'Nile 1',
                'slug' => 'nile-1',
                'vehicle_make_id' => $makesByName['Egypt Auto'] ?? null,
                'logo' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Desert X',
                'slug' => 'desert-x',
                'vehicle_make_id' => $makesByName['Saudi Motors'] ?? null,
                'logo' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Falcon S',
                'slug' => 'falcon-s',
                'vehicle_make_id' => $makesByName['Emirates Mobility'] ?? null,
                'logo' => null,
                'is_active' => true,
            ],
        ];

        foreach ($models as $model) {
            VehicleMakeModel::updateOrCreate(
                ['vehicle_make_id' => $model['vehicle_make_id'], 'name' => $model['name']],
                $model
            );
        }
    }
}
