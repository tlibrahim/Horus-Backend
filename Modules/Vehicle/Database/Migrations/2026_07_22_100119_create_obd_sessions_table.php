<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Vehicle\Enums\ConnectionType;
use Modules\Vehicle\Enums\ObdSessionStatus;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('obd_sessions', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('vehicle_obd_device_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->uuid('session_uuid')->unique();

            $table->string('connection_type')
                ->default(ConnectionType::Bluetooth->value);

            $table->string('status')
                ->default(ObdSessionStatus::Connecting->value);

            $table->timestamp('started_at');

            $table->timestamp('ended_at')->nullable();

            $table->timestamp('last_activity_at');

            $table->string('ip_address')->nullable();

            $table->string('firmware_version')->nullable();

            $table->json('metadata')->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('vehicle_obd_device_id');

            $table->index('status');

            $table->index('last_activity_at');

            $table->index([
                'vehicle_obd_device_id',
                'status',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obd_sessions');
    }
};
