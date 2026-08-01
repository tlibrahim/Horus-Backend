<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_sessions', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_device_id')
                ->constrained('user_devices')
                ->cascadeOnDelete();

            $table->string('jwt_id')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamp('revoked_at')->nullable();
            $table->timestamp('logout_at')->nullable();
            $table->boolean('remember_me')->default(false);

            $table->timestamps();

            $table->unique([
                'user_id',
                'user_device_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_sessions');
    }
};
