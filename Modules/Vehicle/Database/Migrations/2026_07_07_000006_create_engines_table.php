<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('engines', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('generation_id')->constrained('generations')->cascadeOnDelete();
            $table->string('code');
            $table->string('name');
            $table->decimal('displacement', 4, 1)->nullable();
            $table->unsignedSmallInteger('horse_power')->nullable();
            $table->unsignedSmallInteger('torque')->nullable();
            $table->foreignId('fuel_type_id')->constrained('fuel_types')->restrictOnDelete();
            $table->foreignId('transmission_id')->constrained('transmissions')->restrictOnDelete();
            $table->boolean('is_active')->default(true);

            $table->unique(['generation_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('engines');
    }
};
