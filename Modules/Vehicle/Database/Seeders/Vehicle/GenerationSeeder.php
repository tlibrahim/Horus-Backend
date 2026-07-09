<?php

namespace Modules\Vehicle\Database\Seeders\Vehicle;

use Illuminate\Database\Seeder;
use Modules\Vehicle\Models\Generation;
use Modules\Vehicle\Models\VehicleModel;

class GenerationSeeder extends Seeder
{
    public function run(): void
    {
        $models = VehicleModel::whereIn('slug', ['toyota-corolla', 'honda-civic'])->pluck('id', 'slug');

        $generations = [
            [
                'model_slug' => 'toyota-corolla',
                'name' => 'Corolla E170',
                'start_year' => 2013,
                'end_year' => 2018,
            ],
            [
                'model_slug' => 'toyota-corolla',
                'name' => 'Corolla E210',
                'start_year' => 2018,
                'end_year' => null,
            ],
            [
                'model_slug' => 'honda-civic',
                'name' => 'Civic 10th Gen',
                'start_year' => 2015,
                'end_year' => 2021,
            ],
            [
                'model_slug' => 'honda-civic',
                'name' => 'Civic 11th Gen',
                'start_year' => 2021,
                'end_year' => null,
            ],
        ];

        foreach ($generations as $generation) {
            if (! isset($models[$generation['model_slug']])) {
                continue;
            }

            Generation::updateOrCreate(
                [
                    'model_id' => $models[$generation['model_slug']],
                    'name' => $generation['name'],
                ],
                [
                    'start_year' => $generation['start_year'],
                    'end_year' => $generation['end_year'],
                    'is_active' => true,
                ],
            );
        }
    }
}
