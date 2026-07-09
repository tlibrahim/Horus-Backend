<?php

namespace Modules\Vehicle\Database\Seeders\Vehicle;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Vehicle\Models\Transmission;

class TransmissionSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Manual', 'Automatic', 'CVT', 'DCT', 'AMT'] as $name) {
            Transmission::updateOrCreate(
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
