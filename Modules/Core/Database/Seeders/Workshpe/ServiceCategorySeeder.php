<?php

namespace Modules\Core\Database\Seeders\Workshpe;

use Illuminate\Database\Seeder;
use Modules\Core\Models\ServiceCategory;

class ServiceCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Maintenance', 'icone' => 'wrench', 'is_active' => true],
            ['name' => 'Repair', 'icone' => 'tool', 'is_active' => true],
            ['name' => 'Inspection', 'icone' => 'clipboard-check', 'is_active' => true],
        ];

        foreach ($categories as $category) {
            ServiceCategory::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
