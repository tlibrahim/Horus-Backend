<?php

declare(strict_types=1);

namespace Modules\Core\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Core\Models\FeatureFlag;

final class FeatureFlagFactory extends Factory
{
    protected $model = FeatureFlag::class;

    public function definition(): array
    {
        return [
            'key' => fake()->unique()->slug(),

            'enabled' => fake()->boolean(),

            'description' => fake()->sentence(),
        ];
    }

    public function enabled(): static
    {
        return $this->state([
            'enabled' => true,
        ]);
    }

    public function disabled(): static
    {
        return $this->state([
            'enabled' => false,
        ]);
    }
}
