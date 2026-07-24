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
        Schema::create('restaurant_tables', function (Blueprint $table) {
            $table->id();
            $table->string('table_number');
            $table->string('area')->default('Comedor Principal');
            $table->integer('capacity')->default(4);
            $table->string('status')->default('libre'); // libre, reservada, ocupada, limpieza
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('reservation_time')->nullable();
            $table->integer('party_size')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_tables');
    }
};
