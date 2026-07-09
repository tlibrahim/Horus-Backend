<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('login_histories', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('user_device_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->ipAddress('ip_address')->nullable();
            $table->string('platform')->nullable();
            $table->boolean('is_success')->default(true);
            $table->string('failure_reason')->nullable();
            $table->timestamp('logged_in_at');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('login_histories');
    }
};
