<?php

declare(strict_types=1);

namespace Modules\Vehicle\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\IAM\Models\User;
use Modules\Vehicle\Enums\OwnershipType;
use Modules\Vehicle\Models\Vehicle;
use Modules\Vehicle\Models\VehicleOwner;

/**
 * @extends Factory<VehicleOwner>
 */
final class VehicleOwnerFactory extends Factory
{
    protected $model = VehicleOwner::class;

    public function definition(): array
    {
        return [
            'vehicle_id' => Vehicle::query()->firstOrFail()->id,

            'user_id' => User::query()->firstOrFail()->id,

            'ownership_type' => fake()->randomElement(OwnershipType::cases())->value,

            'ownership_percentage' => 100,

            'started_at' => fake()->dateTimeBetween('-3 years', '-1 month'),

            'ended_at' => null,

            'is_primary' => true,

            'notes' => fake()->optional()->sentence(),
        ];
    }

    public function previousOwner(): static
    {
        return $this->state(fn () => [
            'ended_at' => fake()->dateTimeBetween('-1 year', '-1 day'),
            'is_primary' => false,
        ]);
    }

    public function coOwner(): static
    {
        return $this->state(fn () => [
            'ownership_type' => OwnershipType::SECONDARY_DRIVER->value,
            'ownership_percentage' => 50,
        ]);
    }

    public function lessee(): static
    {
        return $this->state(fn () => [
            'ownership_type' => OwnershipType::LEASE->value,
            'ownership_percentage' => 100,
        ]);
    }
}
