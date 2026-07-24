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
        // 1. Modifiers (e.g., "Tamaño", "Tipo de Leche", "Extras")
        Schema::create('modifiers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->enum('type', ['radio', 'checkbox', 'select'])->default('radio');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

        // 2. Modifier Options (e.g., "Chico", "Grande +$15", "Deslactosada")
        Schema::create('modifier_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('modifier_id');
            $table->string('name', 150);
            $table->decimal('price_adjustment', 10, 2)->default(0.00);
            $table->boolean('is_default')->default(0);
            $table->boolean('is_active')->default(1);
            $table->timestamps();

            $table->foreign('modifier_id')->references('id')->on('modifiers')->onDelete('cascade');
        });

        // 3. Product-Modifier Pivot (Links a product to a modifier group)
        Schema::create('product_modifier', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('modifier_id');
            $table->boolean('is_required')->default(0);
            $table->integer('max_selections')->default(1);
            $table->timestamps();

            $table->unique(['product_id', 'modifier_id']);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('modifier_id')->references('id')->on('modifiers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_modifiers_tables');
    }
};
