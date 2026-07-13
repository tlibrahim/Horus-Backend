<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('brand_id')
                ->constrained();

            $table->foreignId('model_id')
                ->constrained();

            $table->foreignId('generation_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('engine_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('body_type_id')
                ->nullable()
                ->constrained();

            $table->foreignId('drive_type_id')
                ->nullable()
                ->constrained();

            $table->foreignId('vehicle_type_id')
                ->nullable()
                ->constrained();

            $table->string('vin', 17)->nullable()->unique();

            $table->string('plate_number')->nullable();

            $table->unsignedSmallInteger('manufacture_year');

            $table->unsignedInteger('current_mileage')->default(0);

            $table->string('color')->nullable();

            $table->boolean('is_primary')->default(false);

            $table->timestamps();

            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
