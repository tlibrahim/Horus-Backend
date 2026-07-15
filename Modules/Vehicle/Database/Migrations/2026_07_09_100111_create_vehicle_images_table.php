<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_images', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('vehicle_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('disk')->default('public');

            $table->string('path');

            $table->string('thumbnail_path')->nullable();

            $table->string('original_name');

            $table->string('mime_type');

            $table->unsignedBigInteger('size');

            $table->unsignedSmallInteger('sort_order')
                ->default(0);

            $table->boolean('is_primary')
                ->default(false);

            $table->timestamps();

            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_images');
    }
};
