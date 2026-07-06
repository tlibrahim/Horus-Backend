<?php

namespace Modules\Core\Database\Seeders\Workshpe;

use Illuminate\Database\Seeder;
use Modules\Core\Models\WorkshopType;

class WorkshopTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name' => 'General Workshop',
                'code' => 'GENERAL_WORKSHOP',
                'description' => 'Handles routine maintenance and general repairs.',
                'is_active' => true,
            ],
            [
                'name' => 'Body Shop',
                'code' => 'BODY_SHOP',
                'description' => 'Specialized in body and paint repair.',
                'is_active' => true,
            ],
            [
                'name' => 'Electrical Workshop',
                'code' => 'ELECTRICAL_WORKSHOP',
                'description' => 'Specialized in diagnostics and electrical systems.',
                'is_active' => true,
            ],
        ];

        foreach ($types as $type) {
            WorkshopType::updateOrCreate(
                ['code' => $type['code']],
                $type
            );
        }
    }
}
