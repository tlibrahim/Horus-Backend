<?php

namespace Modules\Core\Database\Seeders\Workshpe;

use Illuminate\Database\Seeder;
use Modules\Core\Models\ServiceCategory;
use Modules\Core\Models\ServiceCategoryType;

class ServiceCategoryTypeSeeder extends Seeder
{
    public function run(): void
    {
        $categoriesByName = ServiceCategory::whereIn('name', ['Maintenance', 'Repair', 'Inspection'])
            ->pluck('id', 'name');

        $types = [
            [
                'service_category_id' => $categoriesByName['Maintenance'] ?? null,
                'name' => 'Periodic Service',
                'code' => 'PERIODIC_SERVICE',
                'description' => 'Scheduled maintenance and fluid checks.',
                'is_active' => true,
            ],
            [
                'service_category_id' => $categoriesByName['Repair'] ?? null,
                'name' => 'Mechanical Repair',
                'code' => 'MECHANICAL_REPAIR',
                'description' => 'Engine, transmission, and suspension repairs.',
                'is_active' => true,
            ],
            [
                'service_category_id' => $categoriesByName['Inspection'] ?? null,
                'name' => 'Pre-Purchase Inspection',
                'code' => 'PRE_PURCHASE_INSPECTION',
                'description' => 'Comprehensive condition and safety inspection.',
                'is_active' => true,
            ],
        ];

        foreach ($types as $type) {
            ServiceCategoryType::updateOrCreate(
                ['service_category_id' => $type['service_category_id'], 'name' => $type['name']],
                $type
            );
        }
    }
}
