<?php

namespace Modules\Core\Database\Seeders\Vehicle;

use Illuminate\Database\Seeder;
use Modules\Core\Models\BodyType;

class BodyTypeSeeder extends Seeder
{
    public function run(): void
    {
        $bodyTypes = [
            [
                'name' => 'Sedan',
                'code' => 'SEDAN',
                'discription' => 'Passenger car with a separate trunk.',
                'is_active' => true,
            ],
            [
                'name' => 'SUV',
                'code' => 'SUV',
                'discription' => 'Sport utility vehicle with higher ride height.',
                'is_active' => true,
            ],
            [
                'name' => 'Hatchback',
                'code' => 'HATCHBACK',
                'discription' => 'Compact car with rear hatch door.',
                'is_active' => true,
            ],
        ];

        foreach ($bodyTypes as $bodyType) {
            BodyType::updateOrCreate(
                ['code' => $bodyType['code']],
                $bodyType
            );
        }
    }
}
