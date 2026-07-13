<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_services', function (Blueprint $table): void {
            $table->id('id');

            $table->foreignId('vehicle_id')
                ->constrained()
                ->cascadeOnDelete();

            // $table->foreignId('workshop_id')
            //     ->nullable()
            //     ->constrained()
            //     ->nullOnDelete();

            $table->string('service_type');

            $table->unsignedInteger('mileage');

            $table->decimal('cost', 10, 2)->default(0);

            $table->date('performed_at');

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_services');
    }
};
