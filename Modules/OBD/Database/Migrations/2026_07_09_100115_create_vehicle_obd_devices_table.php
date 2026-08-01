<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_obd_devices', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('vehicle_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('obd_device_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamp('paired_at');

            $table->timestamp('unpaired_at')->nullable();

            $table->boolean('is_active')->default(true);

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['vehicle_id', 'is_active']);
            $table->index(['obd_device_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_obd_devices');
    }
};
