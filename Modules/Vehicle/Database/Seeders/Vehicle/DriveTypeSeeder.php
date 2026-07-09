<?php

namespace Modules\Vehicle\Database\Seeders\Vehicle;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Vehicle\Models\DriveType;

class DriveTypeSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['FWD', 'RWD', 'AWD', '4WD'] as $name) {
            DriveType::updateOrCreate(
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
