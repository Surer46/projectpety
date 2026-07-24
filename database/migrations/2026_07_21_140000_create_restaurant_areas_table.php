<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('restaurant_areas', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 120)->unique();
            $table->text('description')->nullable();
            $table->string('emoji', 10)->nullable()->default('🪑');
            $table->string('icon', 60)->nullable()->default('table_restaurant');
            $table->string('color', 20)->nullable()->default('#c79c5e');
            $table->integer('capacity')->nullable();
            $table->string('floor', 50)->nullable();
            $table->time('schedule_open')->nullable();
            $table->time('schedule_close')->nullable();
            $table->boolean('is_outdoor')->default(false);
            $table->boolean('requires_reservation')->default(false);
            $table->decimal('min_consumption', 10, 2)->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_areas');
    }
};
