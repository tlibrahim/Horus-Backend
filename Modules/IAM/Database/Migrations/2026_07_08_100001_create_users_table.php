<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {

            $table->id();
            $table->uuid('uuid')->unique();

            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('display_name', 100)->nullable();
            $table->string('full_name', 100)->nullable();

            $table->string('email')->nullable()->unique();
            $table->string('mobile', 30)->unique();

            // Nullable because users will register via OTP first.
            $table->string('password')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->boolean('is_verified')->default(false);

            $table->string('avatar')->nullable();

            $table->foreignId('country_id')
                ->nullable()
                ->constrained('countries')
                ->nullOnDelete();

            $table->foreignId('language_id')
                ->nullable()
                ->constrained('languages')
                ->nullOnDelete();

            $table->foreignId('timezone_id')
                ->nullable()
                ->constrained('timezones')
                ->nullOnDelete();

            $table->timestamp('last_login_at')->nullable();

            $table->boolean('is_active')->default(true);

            $table->rememberToken();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['mobile']);
            $table->index(['email']);
            $table->index(['is_active']);
            $table->index(['is_verified']);
            $table->index(['country_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
