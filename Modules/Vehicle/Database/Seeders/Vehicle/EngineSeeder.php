<?php

namespace Modules\Vehicle\Database\Seeders\Vehicle;

use Illuminate\Database\Seeder;
use Modules\Vehicle\Models\Engine;
use Modules\Vehicle\Models\FuelType;
use Modules\Vehicle\Models\Generation;
use Modules\Vehicle\Models\Transmission;

class EngineSeeder extends Seeder
{
    public function run(): void
    {
        $generations = Generation::whereIn('name', ['Corolla E170', 'Corolla E210', 'Civic 10th Gen', 'Civic 11th Gen'])
            ->pluck('id', 'name');

        $fuelTypes = FuelType::whereIn('slug', ['gasoline', 'diesel'])
            ->pluck('id', 'slug');

        $transmissions = Transmission::whereIn('slug', ['manual', 'automatic', 'cvt'])
            ->pluck('id', 'slug');

        $engines = [
            [
                'generation_name' => 'Corolla E170',
                'code' => '2ZR-FE',
                'name' => '1.8L Inline-4',
                'displacement' => 1.8,
                'horse_power' => 140,
                'torque' => 173,
                'fuel_slug' => 'gasoline',
                'transmission_slug' => 'cvt',
            ],
            [
                'generation_name' => 'Corolla E210',
                'code' => 'M20A',
                'name' => '2.0L Dynamic Force',
                'displacement' => 2.0,
                'horse_power' => 169,
                'torque' => 205,
                'fuel_slug' => 'gasoline',
                'transmission_slug' => 'cvt',
            ],
            [
                'generation_name' => 'Civic 10th Gen',
                'code' => 'K20A',
                'name' => '2.0L i-VTEC',
                'displacement' => 2.0,
                'horse_power' => 158,
                'torque' => 187,
                'fuel_slug' => 'gasoline',
                'transmission_slug' => 'automatic',
            ],
            [
                'generation_name' => 'Civic 11th Gen',
                'code' => '1KD-FTV',
                'name' => '3.0L Turbo Diesel',
                'displacement' => 3.0,
                'horse_power' => 171,
                'torque' => 410,
                'fuel_slug' => 'diesel',
                'transmission_slug' => 'manual',
            ],
        ];

        foreach ($engines as $engine) {
            if (! isset($generations[$engine['generation_name']], $fuelTypes[$engine['fuel_slug']], $transmissions[$engine['transmission_slug']])) {
                continue;
            }

            Engine::updateOrCreate(
                [
                    'generation_id' => $generations[$engine['generation_name']],
                    'code' => $engine['code'],
                ],
                [
                    'name' => $engine['name'],
                    'displacement' => $engine['displacement'],
                    'horse_power' => $engine['horse_power'],
                    'torque' => $engine['torque'],
                    'fuel_type_id' => $fuelTypes[$engine['fuel_slug']],
                    'transmission_id' => $transmissions[$engine['transmission_slug']],
                    'is_active' => true,
                ],
            );
        }
    }
}
