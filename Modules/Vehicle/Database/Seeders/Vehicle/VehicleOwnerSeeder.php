<?php

declare(strict_types=1);

namespace Modules\Vehicle\Database\Seeders\Vehicle;

use Illuminate\Database\Seeder;
use Modules\Vehicle\Models\VehicleOwner;

final class VehicleOwnerSeeder extends Seeder
{
    public function run(): void
    {
        VehicleOwner::factory()
            ->count(10)
            ->create();
    }
}
