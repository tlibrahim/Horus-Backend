<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_devices', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->uuid('device_uuid');
            $table->string('platform');
            $table->string('device_name')->nullable();
            $table->string('os_version')->nullable();
            $table->string('app_version')->nullable();
            $table->text('firebase_token')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique([
                'user_id',
                'device_uuid',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_devices');
    }
};
