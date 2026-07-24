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
        // 1. Cajas Físicas
        Schema::create('cash_registers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

        // Insert default register
        DB::table('cash_registers')->insert([
            'name' => 'Caja Principal',
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Sesiones de Caja (Turnos)
        Schema::create('cash_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cash_register_id');
            $table->unsignedBigInteger('user_id');
            $table->decimal('opening_amount', 12, 2)->default(0.00); // Fondo inicial
            $table->decimal('closing_amount', 12, 2)->nullable(); // Monto declarado al cierre
            $table->decimal('expected_amount', 12, 2)->nullable(); // Monto que el sistema calculó
            $table->decimal('difference', 12, 2)->nullable(); // Sobrante (+) o faltante (-)
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamp('opened_at')->useCurrent();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();

            $table->foreign('cash_register_id')->references('id')->on('cash_registers')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_management_tables');
    }
};
