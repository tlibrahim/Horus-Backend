<?php

namespace Modules\Core\Database\Seeders\Vehicle;

use Illuminate\Database\Seeder;
use Modules\Core\Models\EmissionStandard;

class EmissionStandardSeeder extends Seeder
{
    public function run(): void
    {
        $standards = [
            [
                'name' => 'Euro 4',
                'code' => 'EURO_4',
                'discription' => 'European emission standard Euro 4.',
                'is_active' => true,
            ],
            [
                'name' => 'Euro 5',
                'code' => 'EURO_5',
                'discription' => 'European emission standard Euro 5.',
                'is_active' => true,
            ],
            [
                'name' => 'Euro 6',
                'code' => 'EURO_6',
                'discription' => 'European emission standard Euro 6.',
                'is_active' => true,
            ],
        ];

        foreach ($standards as $standard) {
            EmissionStandard::updateOrCreate(
                ['code' => $standard['code']],
                $standard
            );
        }
    }
}
