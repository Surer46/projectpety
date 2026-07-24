<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promotion;
use App\Models\Product;
use App\Models\RestaurantTable;
use Illuminate\Support\Facades\DB;

class PromotionsMealsController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'mesas');

        $promotions = Promotion::orderBy('created_at', 'desc')->get();
        $products = Product::where('is_active', 1)->orderBy('name')->get();
        $categories = DB::table('categories')->where('is_active', 1)->orderBy('name')->get();

        $dailyMealsCategory = DB::table('categories')->where('slug', 'comidas-del-dia')->first();
        $dailyMeals = [];
        if ($dailyMealsCategory) {
            $dailyMeals = Product::where('category_id', $dailyMealsCategory->id)->orderBy('id', 'desc')->get();
        }

        // Tablas y reservaciones para el control administrativo de mesas
        $tables = RestaurantTable::orderBy('id')->get();
        $activeReservations = RestaurantTable::where('status', '!=', 'libre')->orderBy('updated_at', 'desc')->get();

        return view('admin.promociones_comidas', compact('tab', 'promotions', 'products', 'categories', 'dailyMeals', 'tables', 'activeReservations'));
    }

    public function storePromotion(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'discount_type' => 'required|in:percentage,fixed_amount',
            'discount_value' => 'required|numeric|min:0.01',
            'applies_to' => 'required|in:all,product,category',
        ]);

        Promotion::create([
            'name' => $request->input('name'),
            'promotion_type' => 'automatic',
            'discount_type' => $request->input('discount_type'),
            'discount_value' => $request->input('discount_value'),
            'applies_to' => $request->input('applies_to'),
            'target_id' => $request->input('applies_to') === 'product' ? $request->input('product_id') : ($request->input('applies_to') === 'category' ? $request->input('category_id') : null),
            'description' => $request->input('description', 'Promoción configurada por el administrador'),
            'is_active' => 1,
        ]);

        return redirect()->route('promotions-meals.index', ['tab' => 'promociones'])->with('success', 'Promoción creada con éxito');
    }

    public function togglePromotion($id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->is_active = !$promotion->is_active;
        $promotion->save();

        return response()->json(['success' => true, 'is_active' => $promotion->is_active]);
    }

    public function storeDailyMeal(Request $request)
    {
        $category = DB::table('categories')->where('slug', 'comidas-del-dia')->first();
        $categoryId = $category ? $category->id : 1;

        // Si seleccionó un producto existente del catálogo
        if ($request->filled('existing_product_id')) {
            $existing = Product::findOrFail($request->input('existing_product_id'));
            $existing->update([
                'category_id' => $categoryId,
                'is_featured' => 1,
                'is_active' => 1
            ]);
            return redirect()->route('promotions-meals.index', ['tab' => 'comidas'])->with('success', 'Producto existente agregado a Comidas del Día');
        }

        $request->validate([
            'name' => 'required|string|max:150',
            'base_price' => 'required|numeric|min:0',
        ]);

        $imagePath = null;
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $file->move(public_path('uploads/products'), $filename);
            $imagePath = '/uploads/products/' . $filename;
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->input('image_url');
        }

        Product::create([
            'category_id' => $categoryId,
            'name' => $request->input('name'),
            'description' => $request->input('description', 'Platillo del Día / Menú Ejecutivo'),
            'base_price' => $request->input('base_price'),
            'emoji' => '🍽️',
            'image_path' => $imagePath,
            'is_active' => 1,
            'is_featured' => 1,
            'stock' => $request->input('stock', 99),
            'allow_modifiers' => 0
        ]);

        return redirect()->route('promotions-meals.index', ['tab' => 'comidas'])->with('success', 'Platillo del Día configurado con éxito');
    }

    public function updateDailyMeal(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
            'name' => 'required|string|max:150',
            'base_price' => 'required|numeric|min:0',
        ]);

        $product = Product::findOrFail($request->input('id'));

        $imagePath = $product->image_path;
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $file->move(public_path('uploads/products'), $filename);
            $imagePath = '/uploads/products/' . $filename;
        } elseif ($request->filled('image_url')) {
            $imagePath = $request->input('image_url');
        }

        $product->update([
            'name' => $request->input('name'),
            'base_price' => $request->input('base_price'),
            'stock' => $request->input('stock', 99),
            'description' => $request->input('description'),
            'image_path' => $imagePath,
        ]);

        return redirect()->route('promotions-meals.index', ['tab' => 'comidas'])->with('success', 'Platillo del Día actualizado con éxito');
    }

    public function destroyDailyMeal($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('promotions-meals.index', ['tab' => 'comidas'])->with('success', 'Platillo removido del menú del día.');
    }

    public function toggleDailyMeal($id)
    {
        $product = Product::findOrFail($id);
        $product->is_active = !$product->is_active;
        $product->save();

        return response()->json(['success' => true, 'is_active' => $product->is_active]);
    }

    // Acciones administrativas de Mesas
    public function occupyTable($id)
    {
        $table = RestaurantTable::findOrFail($id);
        $table->update(['status' => 'ocupada']);
        return redirect()->route('promotions-meals.index', ['tab' => 'mesas'])->with('success', 'Mesa ' . $table->table_number . ' marcada como ocupada.');
    }

    public function releaseTable($id)
    {
        $table = RestaurantTable::findOrFail($id);
        $table->update([
            'status' => 'libre',
            'customer_name' => null,
            'customer_phone' => null,
            'reservation_time' => null,
            'party_size' => null,
            'notes' => null,
        ]);
        return redirect()->route('promotions-meals.index', ['tab' => 'mesas'])->with('success', 'Mesa ' . $table->table_number . ' liberada correctamente.');
    }
}
