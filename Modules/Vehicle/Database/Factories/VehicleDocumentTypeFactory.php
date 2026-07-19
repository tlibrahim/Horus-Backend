<?php

declare(strict_types=1);

namespace Modules\Vehicle\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Vehicle\Models\VehicleDocumentType;

/**
 * @extends Factory<VehicleDocumentType>
 */
final class VehicleDocumentTypeFactory extends Factory
{
    protected $model = VehicleDocumentType::class;

    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Registration',
            'Insurance',
            'Ownership',
            'Inspection',
            'Warranty',
            'Road Permit',
        ]);

        return [
            'name' => $name,

            'slug' => Str::slug($name),

            'requires_expiry' => fake()->boolean(),

            'requires_number' => fake()->boolean(),

            'is_active' => true,
        ];
    }

    public function requiresExpiry(): static
    {
        return $this->state(fn () => [
            'requires_expiry' => true,
        ]);
    }

    public function requiresNumber(): static
    {
        return $this->state(fn () => [
            'requires_number' => true,
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn () => [
            'is_active' => false,
        ]);
    }
}
