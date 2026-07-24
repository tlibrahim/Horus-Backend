<?php

declare(strict_types=1);

namespace Modules\Vehicle\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Vehicle\Enums\ConnectionType;
use Modules\Vehicle\Enums\ObdSessionStatus;
use Modules\Vehicle\Models\ObdSession;
use Modules\Vehicle\Models\VehicleObdDevice;

/**
 * @extends Factory<ObdSession>
 */
final class ObdSessionFactory extends Factory
{
    protected $model = ObdSession::class;

    public function definition(): array
    {
        return [
            'vehicle_obd_device_id' => VehicleObdDevice::factory(),

            'session_uuid' => (string) Str::uuid(),

            'connection_type' => fake()->randomElement(
                ConnectionType::values(),
            ),

            'status' => ObdSessionStatus::Connected,

            'started_at' => now(),

            'ended_at' => null,

            'last_activity_at' => now(),

            'ip_address' => fake()->ipv4(),

            'firmware_version' => fake()->numerify('v#.#.#'),

            'metadata' => [
                'sdk_version' => fake()->numerify('#.#.#'),
                'device_name' => fake()->word(),
            ],
        ];
    }

    public function connecting(): static
    {
        return $this->state(fn (): array => [
            'status' => ObdSessionStatus::Connecting,
        ]);
    }

    public function connected(): static
    {
        return $this->state(fn (): array => [
            'status' => ObdSessionStatus::Connected,
            'ended_at' => null,
        ]);
    }

    public function disconnected(): static
    {
        return $this->state(fn (): array => [
            'status' => ObdSessionStatus::Disconnected,
            'ended_at' => now(),
        ]);
    }

    public function failed(): static
    {
        return $this->state(fn (): array => [
            'status' => ObdSessionStatus::Failed,
            'ended_at' => now(),
        ]);
    }
}
