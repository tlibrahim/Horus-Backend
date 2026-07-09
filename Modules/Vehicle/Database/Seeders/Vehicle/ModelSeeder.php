<?php

namespace Modules\Vehicle\Database\Seeders\Vehicle;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Vehicle\Models\Brand;
use Modules\Vehicle\Models\VehicleModel;

class ModelSeeder extends Seeder
{
    public function run(): void
    {
        $brands = Brand::whereIn('slug', ['toyota', 'honda', 'hyundai'])->pluck('id', 'slug');

        $models = [
            ['brand_slug' => 'toyota', 'name' => 'Corolla'],
            ['brand_slug' => 'toyota', 'name' => 'Camry'],
            ['brand_slug' => 'honda', 'name' => 'Civic'],
            ['brand_slug' => 'hyundai', 'name' => 'Accent'],
            ['brand_slug' => 'hyundai', 'name' => 'Elantra'],
        ];

        foreach ($models as $model) {
            if (! isset($brands[$model['brand_slug']])) {
                continue;
            }

            $slug = Str::slug($model['brand_slug'].'-'.$model['name']);

            VehicleModel::updateOrCreate(
                ['slug' => $slug],
                [
                    'brand_id' => $brands[$model['brand_slug']],
                    'name' => $model['name'],
                    'slug' => $slug,
                    'is_active' => true,
                ],
            );
        }
    }
}
