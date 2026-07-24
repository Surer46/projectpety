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
        // 1. Orders
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 50)->unique();
            $table->unsignedBigInteger('user_id')->nullable(); // Cashier who took the order
            $table->string('customer_name', 150)->nullable()->default('Mostrador');
            $table->enum('order_type', ['dine_in', 'takeout', 'delivery'])->default('takeout');
            $table->string('status', 50)->default('pending');
            $table->decimal('subtotal', 12, 2)->default(0.00);
            $table->decimal('tax_amount', 12, 2)->default(0.00);
            $table->decimal('discount_amount', 12, 2)->default(0.00);
            $table->decimal('total_amount', 12, 2)->default(0.00);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

        // 2. Order Items
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('product_name', 150); // Snapshot of product name
            $table->decimal('quantity', 10, 2)->default(1.00);
            $table->decimal('unit_price', 12, 2)->default(0.00);
            $table->decimal('total_price', 12, 2)->default(0.00);
            $table->json('modifiers')->nullable(); // Store chosen modifiers like {"size": "Grande", "milk": "Deslactosada"}
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
        });

        // 3. Payments
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->enum('payment_method', ['cash', 'card', 'mixed', 'transfer'])->default('cash');
            $table->decimal('amount_paid', 12, 2)->default(0.00); // How much of the order total this covers
            $table->decimal('amount_tendered', 12, 2)->default(0.00); // How much cash was handed by the customer
            $table->decimal('change_returned', 12, 2)->default(0.00); // Change given back
            $table->string('transaction_reference', 100)->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_and_payments_tables');
    }
};
