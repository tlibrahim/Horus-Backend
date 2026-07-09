<?php

namespace Modules\Vehicle\Database\Seeders\Vehicle;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Vehicle\Models\BodyType;

class BodyTypeSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Sedan', 'SUV', 'Pickup', 'Coupe', 'Convertible', 'Van', 'Hatchback'] as $name) {
            BodyType::updateOrCreate(
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
