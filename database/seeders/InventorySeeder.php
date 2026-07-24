<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Product;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $branchId = DB::table('branches')->first()->id;

        // 1. Units
        $unitPz = DB::table('units')->insertGetId(['name' => 'Piezas', 'abbreviation' => 'pz', 'created_at' => $now]);
        $unitGr = DB::table('units')->insertGetId(['name' => 'Gramos', 'abbreviation' => 'g', 'created_at' => $now]);
        $unitMl = DB::table('units')->insertGetId(['name' => 'Mililitros', 'abbreviation' => 'ml', 'created_at' => $now]);

        // 2. Ingredients
        $ingVaso = DB::table('ingredients')->insertGetId(['unit_id' => $unitPz, 'name' => 'Vaso 16oz', 'is_active' => 1, 'created_at' => $now]);
        $ingCafe = DB::table('ingredients')->insertGetId(['unit_id' => $unitGr, 'name' => 'Café en Grano', 'is_active' => 1, 'created_at' => $now]);
        $ingLeche = DB::table('ingredients')->insertGetId(['unit_id' => $unitMl, 'name' => 'Leche Entera', 'is_active' => 1, 'created_at' => $now]);

        // 3. Inventory for Ingredients (Plentiful)
        DB::table('inventory_items')->insert([
            ['branch_id' => $branchId, 'ingredient_id' => $ingVaso, 'quantity_on_hand' => 500, 'created_at' => $now],
            ['branch_id' => $branchId, 'ingredient_id' => $ingCafe, 'quantity_on_hand' => 2000, 'created_at' => $now], // 2kg
            ['branch_id' => $branchId, 'ingredient_id' => $ingLeche, 'quantity_on_hand' => 5000, 'created_at' => $now], // 5 Liters
        ]);

        // Get Products
        $cafeId = Product::where('slug', 'cafe-americano-premium')->first()->id;
        $pastelId = Product::where('slug', 'pastel-chocolate-oscuro')->first()->id;
        $frappeId = Product::where('slug', 'frappe-caramelo-macchiato')->first()->id;

        // 4. Recipes
        // Recipe for Café
        $recipeCafe = DB::table('recipes')->insertGetId(['product_id' => $cafeId, 'name' => 'Receta Café Americano', 'created_at' => $now]);
        DB::table('recipe_items')->insert([
            ['recipe_id' => $recipeCafe, 'ingredient_id' => $ingVaso, 'unit_id' => $unitPz, 'quantity' => 1, 'created_at' => $now],
            ['recipe_id' => $recipeCafe, 'ingredient_id' => $ingCafe, 'unit_id' => $unitGr, 'quantity' => 15, 'created_at' => $now],
        ]);

        // Recipe for Frappé
        $recipeFrappe = DB::table('recipes')->insertGetId(['product_id' => $frappeId, 'name' => 'Receta Frappé', 'created_at' => $now]);
        DB::table('recipe_items')->insert([
            ['recipe_id' => $recipeFrappe, 'ingredient_id' => $ingVaso, 'unit_id' => $unitPz, 'quantity' => 1, 'created_at' => $now],
            ['recipe_id' => $recipeFrappe, 'ingredient_id' => $ingLeche, 'unit_id' => $unitMl, 'quantity' => 200, 'created_at' => $now],
            ['recipe_id' => $recipeFrappe, 'ingredient_id' => $ingCafe, 'unit_id' => $unitGr, 'quantity' => 10, 'created_at' => $now],
        ]);

        // 5. Inventory for Direct Products (Pastel) - INTENTIONALLY OUT OF STOCK (0)
        DB::table('inventory_items')->insert([
            ['branch_id' => $branchId, 'product_id' => $pastelId, 'quantity_on_hand' => 0, 'created_at' => $now],
        ]);
    }
}
