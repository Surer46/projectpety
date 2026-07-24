<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Promotion;
use App\Models\Product;
use App\Models\RestaurantArea;
use App\Models\RestaurantTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BackofficeController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'usuarios');

        // Fetch users with their roles via DB join
        $users = User::leftJoin('model_has_roles', function($join) {
                $join->on('users.id', '=', 'model_has_roles.model_id')
                     ->where('model_has_roles.model_type', '=', 'App\Models\User');
            })
            ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.name as role_name')
            ->get();

        $roles = DB::table('roles')->get();
        $branches = \App\Models\Branch::all();
        $promotions = Promotion::orderBy('created_at', 'desc')->get();
        $products = Product::where('is_active', 1)->orderBy('name')->get();
        $categories = DB::table('categories')->where('is_active', 1)->orderBy('name')->get();

        $dailyMealsCategory = DB::table('categories')->where('slug', 'comidas-del-dia')->first();
        $dailyMeals = [];
        if ($dailyMealsCategory) {
            $dailyMeals = Product::where('category_id', $dailyMealsCategory->id)->orderBy('id', 'desc')->get();
        }

        // Cargar áreas físicas y mesas para la pestaña de Áreas / Zonas
        $areas = RestaurantArea::with(['branch'])->withCount('tables')->orderBy('sort_order')->get();
        $tables = RestaurantTable::with('area')->orderBy('table_number')->get();

        // Cargar órdenes para la gestión del flujo de preparación (KDS / Amazon Fulfillment)
        $backofficeOrders = DB::table('orders')
            ->orderBy('created_at', 'desc')
            ->take(30)
            ->get();

        foreach ($backofficeOrders as $o) {
            $o->items = DB::table('order_items')->where('order_id', $o->id)->get();
        }

        return view('admin.backoffice', compact(
            'users', 'roles', 'branches', 'promotions', 'products',
            'categories', 'dailyMeals', 'areas', 'tables', 'backofficeOrders', 'tab'
        ));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_preparation,on_delivery,ready,completed,cancelled',
        ]);

        $status = $request->input('status');
        $driverName = $request->input('driver_name');

        $updateData = [
            'status' => $status,
            'updated_at' => now(),
        ];

        if ($driverName) {
            $updateData['driver_name'] = $driverName;
        }

        DB::table('orders')->where('id', $id)->update($updateData);

        return redirect()->route('backoffice', ['tab' => 'pedidos'])
                         ->with('success', '¡Estado del pedido #' . $id . ' actualizado a: ' . strtoupper($status) . '!');
    }

    // ── GESTIÓN DE ZONAS / ÁREAS FÍSICAS ─────────────────────────────

    public function storeArea(Request $request)
    {
        $request->validate([
            'branch_id'            => 'required|exists:branches,id',
            'name'                 => 'required|string|max:100',
            'description'          => 'nullable|string|max:500',
            'emoji'                => 'nullable|string|max:10',
            'icon'                 => 'nullable|string|max:60',
            'color'                => 'nullable|string|max:20',
            'floor'                => 'nullable|string|max:50',
            'capacity'             => 'nullable|integer|min:1',
            'schedule_open'        => 'nullable|string',
            'schedule_close'       => 'nullable|string',
            'min_consumption'      => 'nullable|numeric|min:0',
            'sort_order'           => 'nullable|integer|min:0',
        ]);

        RestaurantArea::create([
            'branch_id'            => $request->input('branch_id'),
            'name'                 => $request->input('name'),
            'slug'                 => Str::slug($request->input('name')),
            'description'          => $request->input('description'),
            'emoji'                => $request->input('emoji', '🪑'),
            'icon'                 => $request->input('icon', 'table_restaurant'),
            'color'                => $request->input('color', '#c79c5e'),
            'capacity'             => $request->input('capacity'),
            'floor'                => $request->input('floor', 'Planta Baja'),
            'schedule_open'        => $request->input('schedule_open'),
            'schedule_close'       => $request->input('schedule_close'),
            'is_outdoor'           => $request->has('is_outdoor') ? 1 : 0,
            'requires_reservation' => $request->has('requires_reservation') ? 1 : 0,
            'min_consumption'      => $request->input('min_consumption'),
            'sort_order'           => $request->input('sort_order', 0),
            'is_active'            => 1,
            'notes'                => $request->input('notes'),
        ]);

        return redirect()->route('backoffice', ['tab' => 'areas'])
                         ->with('success', '¡Zona física creada con éxito!');
    }

    public function updateArea(Request $request, $id)
    {
        $area = RestaurantArea::findOrFail($id);

        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'name'      => 'required|string|max:100',
        ]);

        $area->update([
            'branch_id'            => $request->input('branch_id'),
            'name'                 => $request->input('name'),
            'slug'                 => Str::slug($request->input('name')),
            'description'          => $request->input('description'),
            'emoji'                => $request->input('emoji', '🪑'),
            'icon'                 => $request->input('icon', 'table_restaurant'),
            'color'                => $request->input('color', '#c79c5e'),
            'capacity'             => $request->input('capacity'),
            'floor'                => $request->input('floor'),
            'schedule_open'        => $request->input('schedule_open'),
            'schedule_close'       => $request->input('schedule_close'),
            'is_outdoor'           => $request->has('is_outdoor') ? 1 : 0,
            'requires_reservation' => $request->has('requires_reservation') ? 1 : 0,
            'min_consumption'      => $request->input('min_consumption'),
            'sort_order'           => $request->input('sort_order', 0),
            'notes'                => $request->input('notes'),
        ]);

        // Actualizar también el campo de texto en las mesas asociadas para mantener consistencia
        RestaurantTable::where('area_id', $area->id)->update(['area' => $area->name]);

        return redirect()->route('backoffice', ['tab' => 'areas'])
                         ->with('success', '¡Zona física actualizada con éxito!');
    }

    public function toggleArea($id)
    {
        $area = RestaurantArea::findOrFail($id);
        $area->is_active = !$area->is_active;
        $area->save();

        return response()->json(['success' => true, 'is_active' => $area->is_active]);
    }

    public function destroyArea($id)
    {
        $area = RestaurantArea::findOrFail($id);

        if ($area->tables()->count() > 0) {
            return redirect()->route('backoffice', ['tab' => 'areas'])
                             ->with('error', 'No se puede eliminar la zona: tiene mesas asignadas.');
        }

        $area->delete();

        return redirect()->route('backoffice', ['tab' => 'areas'])
                         ->with('success', 'Zona física eliminada correctamente.');
    }

    // ── GESTIÓN DE MESAS DESDE BACKOFFICE ─────────────────────────────

    public function storeTable(Request $request)
    {
        $request->validate([
            'table_number' => 'required|string|max:50',
            'area_id'      => 'required|exists:restaurant_areas,id',
            'capacity'      => 'required|integer|min:1',
        ]);

        $area = RestaurantArea::findOrFail($request->input('area_id'));

        RestaurantTable::create([
            'table_number' => $request->input('table_number'),
            'area_id'      => $area->id,
            'area'         => $area->name,
            'capacity'     => $request->input('capacity'),
            'status'       => 'libre',
        ]);

        return redirect()->route('backoffice', ['tab' => 'areas'])
                         ->with('success', '¡Mesa agregada con éxito a ' . $area->name . '!');
    }

    public function updateTable(Request $request, $id)
    {
        $table = RestaurantTable::findOrFail($id);

        $request->validate([
            'table_number' => 'required|string|max:50',
            'area_id'      => 'required|exists:restaurant_areas,id',
            'capacity'     => 'required|integer|min:1',
            'status'       => 'required|in:libre,reservada,ocupada,limpieza',
        ]);

        $area = RestaurantArea::findOrFail($request->input('area_id'));

        $table->update([
            'table_number' => $request->input('table_number'),
            'area_id'      => $area->id,
            'area'         => $area->name,
            'capacity'     => $request->input('capacity'),
            'status'       => $request->input('status'),
            'notes'        => $request->input('notes'),
        ]);

        return redirect()->route('backoffice', ['tab' => 'areas'])
                         ->with('success', '¡Mesa ' . $table->table_number . ' actualizada con éxito!');
    }

    public function destroyTable($id)
    {
        $table = RestaurantTable::findOrFail($id);
        $table->delete();

        return redirect()->route('backoffice', ['tab' => 'areas'])
                         ->with('success', 'Mesa eliminada correctamente.');
    }

    // ── PROMOCIONES Y COMIDAS DEL DÍA ────────────────────────────────

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

        return redirect()->route('backoffice', ['tab' => 'promociones'])->with('success', 'Promoción creada con éxito');
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
        $request->validate([
            'name' => 'required|string|max:150',
            'base_price' => 'required|numeric|min:0',
        ]);

        $category = DB::table('categories')->where('slug', 'comidas-del-dia')->first();
        $categoryId = $category ? $category->id : 1;

        Product::create([
            'category_id' => $categoryId,
            'name' => $request->input('name'),
            'description' => $request->input('description', 'Platillo del Día / Menú Ejecutivo'),
            'base_price' => $request->input('base_price'),
            'emoji' => $request->input('emoji', '🍽️'),
            'is_active' => 1,
            'is_featured' => 1,
            'stock' => $request->input('stock', 99),
            'allow_modifiers' => 0
        ]);

        return redirect()->route('backoffice', ['tab' => 'promociones'])->with('success', 'Platillo del Día configurado con éxito');
    }

    public function toggleDailyMeal($id)
    {
        $product = Product::findOrFail($id);
        $product->is_active = !$product->is_active;
        $product->save();

        return response()->json(['success' => true, 'is_active' => $product->is_active]);
    }
}
