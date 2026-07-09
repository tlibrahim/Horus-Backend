<?php

namespace Modules\Vehicle\Database\Seeders\Vehicle;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Core\Models\Country;
use Modules\Vehicle\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $countries = Country::whereIn('iso2', ['JP', 'KR', 'DE', 'US'])->pluck('id', 'iso2');

        $brands = [
            ['name' => 'Toyota', 'country_iso2' => 'JP'],
            ['name' => 'Honda', 'country_iso2' => 'JP'],
            ['name' => 'Hyundai', 'country_iso2' => 'KR'],
            ['name' => 'BMW', 'country_iso2' => 'DE'],
            ['name' => 'Mercedes', 'country_iso2' => 'DE'],
            ['name' => 'Ford', 'country_iso2' => 'US'],
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(
                ['slug' => Str::slug($brand['name'])],
                [
                    'name' => $brand['name'],
                    'slug' => Str::slug($brand['name']),
                    'logo' => null,
                    'country_id' => $countries[$brand['country_iso2']] ?? null,
                    'is_active' => true,
                ],
            );
        }
    }
}
