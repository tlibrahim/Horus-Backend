<?php

namespace Modules\OBD\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\OBD\Enums\ConnectionType;
use Modules\OBD\Enums\ObdDeviceStatus;
use Modules\OBD\Models\ObdDevice;

class ObdDeviceFactory extends Factory
{
    protected $model = ObdDevice::class;

    public function definition(): array
    {
        return [
            'serial_number' => strtoupper(fake()->bothify('OBD-########')),
            'manufacturer' => fake()->randomElement([
                'Launch',
                'Autel',
                'Thinkcar',
                'Elm Electronics',
                'Bosch',
            ]),
            'model' => fake()->randomElement([
                'X431',
                'MaxiAP',
                'ELM327',
                'BT200',
                'Pro',
            ]),
            'firmware_version' => fake()->numerify('v#.#.#'),
            'hardware_version' => fake()->numerify('#.#'),
            'connection_type' => fake()->randomElement(ConnectionType::values()),
            'status' => ObdDeviceStatus::Active,
            'mac_address' => fake()->macAddress(),
            'imei' => fake()->optional()->numerify('###############'),
            'sim_number' => fake()->optional()->numerify('####################'),
            'metadata' => [
                'battery' => fake()->numberBetween(50, 100),
                'protocol' => fake()->randomElement([
                    'ISO15765',
                    'ISO9141',
                    'CAN',
                ]),
            ],
            'last_seen_at' => now(),
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn () => [
            'status' => ObdDeviceStatus::Inactive,
        ]);
    }

    public function retired(): static
    {
        return $this->state(fn () => [
            'status' => ObdDeviceStatus::Retired,
        ]);
    }
}
