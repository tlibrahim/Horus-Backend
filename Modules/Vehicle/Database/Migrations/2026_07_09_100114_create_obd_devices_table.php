<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('obd_devices', function (Blueprint $table): void {
            $table->id();

            $table->string('serial_number')->nullable();
            $table->string('mac_address')->nullable();
            $table->string('firmware')->nullable();
            $table->boolean('is_active')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obd_devices');
    }
};
