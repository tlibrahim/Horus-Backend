<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Vehicle\Enums\OwnershipType;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_owners', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('vehicle_id')
                ->constrained('vehicles')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('ownership_type')
                ->default(OwnershipType::OWNER->value);

            $table->decimal('ownership_percentage', 5, 2)
                ->default(100);

            $table->date('started_at');

            $table->date('ended_at')
                ->nullable();

            $table->boolean('is_primary')
                ->default(true);

            $table->text('notes')
                ->nullable();

            $table->timestamps();

            $table->index('vehicle_id');
            $table->index('user_id');
            $table->index('is_primary');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_owners');
    }
};
