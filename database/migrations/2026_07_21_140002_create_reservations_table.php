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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_table_id')->constrained('restaurant_tables')->cascadeOnDelete();
            $table->foreignId('area_id')->nullable()->constrained('restaurant_areas')->nullOnDelete();
            $table->string('customer_name', 150);
            $table->string('customer_phone', 50);
            $table->date('reservation_date');
            $table->time('reservation_time');
            $table->integer('party_size')->default(1);
            $table->string('status', 30)->default('confirmed'); // confirmed, cancelled, completed, no_show
            $table->text('notes')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
