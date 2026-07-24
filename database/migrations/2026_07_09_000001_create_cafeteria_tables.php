<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Branches
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('legal_name', 180)->nullable();
            $table->string('tax_id', 60)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('country', 80)->default('Mexico');
            $table->string('logo_path', 255)->nullable();
            $table->char('currency_code', 3)->default('MXN');
            $table->string('timezone', 80)->default('America/Mexico_City');
            $table->boolean('is_active')->default(1)->index();
            $table->timestamps();
            $table->softDeletes();
        });

        // 2. Categories
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->string('name', 120);
            $table->string('slug', 150)->unique();
            $table->text('description')->nullable();
            $table->string('icon', 80)->nullable();
            $table->string('image_path', 255)->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(1)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('set null');
        });

        // 3. Taxes
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->decimal('rate', 6, 4)->default(0.0000);
            $table->boolean('is_included')->default(1);
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

        // 4. Products
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable()->index();
            $table->unsignedBigInteger('tax_id')->nullable()->index();
            $table->string('sku', 80)->nullable()->unique();
            $table->string('barcode', 80)->nullable();
            $table->string('name', 160);
            $table->string('slug', 180)->unique();
            $table->text('description')->nullable();
            $table->string('image_path', 255)->nullable();
            $table->string('emoji', 20)->nullable();
            $table->decimal('base_price', 12, 2)->default(0.00);
            $table->decimal('cost_price', 12, 2)->default(0.00);
            $table->enum('product_type', ['finished', 'ingredient', 'combo', 'service'])->default('finished');
            $table->enum('preparation_area', ['kitchen', 'bar', 'both', 'none'])->default('bar');
            $table->boolean('track_stock')->default(1);
            $table->boolean('allow_modifiers')->default(1);
            $table->boolean('is_featured')->default(0);
            $table->boolean('is_active')->default(1)->index();
            $table->time('available_from')->nullable();
            $table->time('available_to')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('tax_id')->references('id')->on('taxes')->onDelete('set null');
        });

        // 5. Units & Ingredients
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80);
            $table->string('abbreviation', 20)->unique();
            $table->enum('unit_type', ['mass', 'volume', 'piece', 'time', 'other'])->default('piece');
            $table->decimal('conversion_factor', 18, 6)->default(1.000000);
            $table->unsignedBigInteger('base_unit_id')->nullable();
            $table->timestamps();
        });

        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_id')->index();
            $table->string('sku', 80)->nullable()->unique();
            $table->string('name', 150);
            $table->text('description')->nullable();
            $table->decimal('current_cost', 12, 4)->default(0.0000);
            $table->decimal('minimum_stock', 14, 4)->default(0.0000);
            $table->decimal('maximum_stock', 14, 4)->nullable();
            $table->decimal('reorder_point', 14, 4)->nullable();
            $table->boolean('is_perishable')->default(0);
            $table->integer('shelf_life_days')->nullable();
            $table->boolean('is_active')->default(1)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('unit_id')->references('id')->on('units')->onDelete('restrict');
        });

        // 6. Recipes
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->index();
            $table->string('name', 150);
            $table->decimal('yield_quantity', 14, 4)->default(1.0000);
            $table->text('preparation_instructions')->nullable();
            $table->decimal('estimated_cost', 12, 4)->default(0.0000);
            $table->decimal('waste_percentage', 6, 3)->default(0.000);
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        Schema::create('recipe_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recipe_id');
            $table->unsignedBigInteger('ingredient_id')->index();
            $table->unsignedBigInteger('unit_id');
            $table->decimal('quantity', 14, 4);
            $table->decimal('waste_percentage', 6, 3)->default(0.000);
            $table->string('notes', 255)->nullable();
            $table->timestamps();

            $table->unique(['recipe_id', 'ingredient_id']);
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('restrict');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('restrict');
        });

        // 7. Inventory Items & Movements
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id')->index();
            $table->unsignedBigInteger('ingredient_id')->nullable()->index();
            $table->unsignedBigInteger('product_id')->nullable()->index();
            $table->decimal('quantity_on_hand', 14, 4)->default(0.0000);
            $table->decimal('quantity_reserved', 14, 4)->default(0.0000);
            $table->decimal('average_cost', 12, 4)->default(0.0000);
            $table->timestamps();

            $table->unique(['branch_id', 'ingredient_id']);
            $table->unique(['branch_id', 'product_id']);
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });

        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id')->index();
            $table->unsignedBigInteger('inventory_item_id')->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->enum('movement_type', ['purchase', 'sale', 'adjustment', 'waste', 'transfer_in', 'transfer_out', 'return', 'production']);
            $table->decimal('quantity', 14, 4);
            $table->decimal('unit_cost', 12, 4)->nullable();
            $table->string('reference_type', 120)->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->string('reason', 255)->nullable();
            $table->timestamp('occurred_at')->useCurrent()->index();
            $table->timestamps();

            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('inventory_item_id')->references('id')->on('inventory_items')->onDelete('restrict');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });

        // 8. Promotions
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->enum('promotion_type', ['combo', 'two_for_one', 'happy_hour', 'coupon', 'automatic']);
            $table->string('code', 80)->nullable()->unique();
            $table->text('description')->nullable();
            $table->enum('applies_to', ['all', 'product', 'category'])->default('all');
            $table->unsignedBigInteger('target_id')->nullable();
            $table->enum('discount_type', ['percentage', 'fixed_amount', 'special_price'])->default('percentage');
            $table->decimal('discount_value', 12, 2)->default(0.00);
            $table->decimal('minimum_order_amount', 12, 2)->default(0.00);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->json('days_of_week')->nullable();
            $table->boolean('is_active')->default(1)->index();
            $table->timestamps();
            
            $table->index(['applies_to', 'target_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotions');
        Schema::dropIfExists('inventory_movements');
        Schema::dropIfExists('inventory_items');
        Schema::dropIfExists('recipe_items');
        Schema::dropIfExists('recipes');
        Schema::dropIfExists('ingredients');
        Schema::dropIfExists('units');
        Schema::dropIfExists('products');
        Schema::dropIfExists('taxes');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('branches');
    }
};
