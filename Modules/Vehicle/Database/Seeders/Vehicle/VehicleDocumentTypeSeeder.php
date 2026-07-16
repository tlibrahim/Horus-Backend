<?php

namespace Modules\Vehicle\Database\Seeders\Vehicle;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Vehicle\Models\VehicleDocumentType;

class VehicleDocumentTypeSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Registration', 'Insurance', 'Inspection', 'Warranty', 'Invoice'] as $name) {
            VehicleDocumentType::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'is_active' => true,
                ],
            );
        }
    }
}
