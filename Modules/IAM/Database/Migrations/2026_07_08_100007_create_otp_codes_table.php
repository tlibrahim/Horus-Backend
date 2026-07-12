<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('otp_codes', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('user_id')
                ->nullable();

            $table->string('mobile');
            $table->string('code_hash')->nullable();
            $table->string('purpose');
            $table->timestamp('expires_at');
            $table->timestamp('verified_at')->nullable();
            $table->unsignedTinyInteger('attempts')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('otp_codes');
    }
};
