<?php

declare(strict_types=1);

namespace Modules\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Core\Models\Setting;

final class SettingFactory extends Factory
{
    protected $model = Setting::class;

    public function definition(): array
    {
        return [
            'key' => fake()->unique()->slug(),
            'group' => fake()->randomElement([
                'app',
                'mail',
                'security',
                'uploads',
                'notifications',
            ]),
            'value' => json_encode(fake()->word()),
            'type' => fake()->randomElement([
                'string',
                'integer',
                'float',
                'boolean',
                'array',
                'object',
                'json',
            ]),
            'description' => fake()->sentence(),
            'is_public' => fake()->boolean(),
            'is_editable' => fake()->boolean(),
        ];
    }
}
