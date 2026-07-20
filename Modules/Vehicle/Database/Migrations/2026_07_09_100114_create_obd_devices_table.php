<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Vehicle\Enums\ConnectionType;
use Modules\Vehicle\Enums\ObdDeviceStatus;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('obd_devices', function (Blueprint $table): void {
            $table->id();

            $table->string('serial_number')->unique();

            $table->string('manufacturer');
            $table->string('model');

            $table->string('firmware_version')->nullable();
            $table->string('hardware_version')->nullable();

            $table->string('connection_type')
                ->default(ConnectionType::Bluetooth->value);

            $table->string('status')
                ->default(ObdDeviceStatus::Active->value);

            $table->string('mac_address')->nullable();
            $table->string('imei')->nullable();
            $table->string('sim_number')->nullable();

            $table->jsonb('metadata')->nullable();

            $table->timestamp('last_seen_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('serial_number');
            $table->index('manufacturer');
            $table->index('status');
            $table->index('connection_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obd_devices');
    }
};
