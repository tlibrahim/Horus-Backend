<?php

declare(strict_types=1);

namespace Modules\Vehicle\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Vehicle\Models\Vehicle;
use Modules\Vehicle\Models\VehicleImage;

final class VehicleImageFactory extends Factory
{
    protected $model = VehicleImage::class;

    public function definition(): array
    {
        return [
            'vehicle_id' => Vehicle::query()->value('id'),

            'disk' => 'public',

            'path' => 'vehicles/test/image.jpg',

            'thumbnail_path' => null,

            'original_name' => 'image.jpg',

            'mime_type' => 'image/jpeg',

            'size' => 1024,

            'sort_order' => 0,

            'is_primary' => false,
        ];
    }
}
