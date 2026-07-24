<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        // 1. Productos (Real data from SQLite)
        $productos = Product::orderBy('name')->get();

        // 2. Ingredientes (Mock Data)
        $ingredientes = [
            (object)['Id' => 1, 'Nombre' => 'Café espresso molido', 'Categoria' => 'Café', 'UnitAbreviatura' => 'g', 'StockActual' => 4200, 'StockMinimo' => 1000, 'PrecioPorUnidad' => 0.12, 'AlertaBajoStock' => false],
            (object)['Id' => 2, 'Nombre' => 'Leche entera', 'Categoria' => 'Lácteos', 'UnitAbreviatura' => 'L', 'StockActual' => 18, 'StockMinimo' => 10, 'PrecioPorUnidad' => 18.50, 'AlertaBajoStock' => false],
            (object)['Id' => 3, 'Nombre' => 'Leche de avena', 'Categoria' => 'Vegetal', 'UnitAbreviatura' => 'L', 'StockActual' => 6, 'StockMinimo' => 5, 'PrecioPorUnidad' => 35, 'AlertaBajoStock' => false],
            (object)['Id' => 4, 'Nombre' => 'Azúcar refinada', 'Categoria' => 'Insumo', 'UnitAbreviatura' => 'kg', 'StockActual' => 8.5, 'StockMinimo' => 3, 'PrecioPorUnidad' => 22, 'AlertaBajoStock' => false],
            (object)['Id' => 5, 'Nombre' => 'Harina de trigo', 'Categoria' => 'Insumo', 'UnitAbreviatura' => 'kg', 'StockActual' => 2.2, 'StockMinimo' => 3, 'PrecioPorUnidad' => 18, 'AlertaBajoStock' => true],
            (object)['Id' => 6, 'Nombre' => 'Mantequilla', 'Categoria' => 'Lácteos', 'UnitAbreviatura' => 'g', 'StockActual' => 850, 'StockMinimo' => 500, 'PrecioPorUnidad' => 0.08, 'AlertaBajoStock' => false],
            (object)['Id' => 7, 'Nombre' => 'Té negro en hoja', 'Categoria' => 'Infusión', 'UnitAbreviatura' => 'g', 'StockActual' => 320, 'StockMinimo' => 200, 'PrecioPorUnidad' => 0.35, 'AlertaBajoStock' => false],
            (object)['Id' => 8, 'Nombre' => 'Canela en polvo', 'Categoria' => 'Especia', 'UnitAbreviatura' => 'g', 'StockActual' => 95, 'StockMinimo' => 100, 'PrecioPorUnidad' => 0.40, 'AlertaBajoStock' => true],
        ];

        // 3. Recetas (Mock Data)
        $recetas = [
            (object)[
                'Id' => 1, 'Nombre' => 'Latte Especial', 'ProductoNombre' => 'Latte Especial', 'Emoji' => '☕', 'Porciones' => 1, 'CostoEstimado' => 12.50,
                'Ingredientes' => [
                    (object)['IngredienteNombre' => 'Café espresso molido', 'Cantidad' => 18, 'Unidad' => 'g'],
                    (object)['IngredienteNombre' => 'Leche entera', 'Cantidad' => 180, 'Unidad' => 'mL'],
                    (object)['IngredienteNombre' => 'Azúcar refinada', 'Cantidad' => 10, 'Unidad' => 'g']
                ]
            ],
            (object)[
                'Id' => 2, 'Nombre' => 'Cheesecake de Fresa', 'ProductoNombre' => 'Cheesecake de Fresa', 'Emoji' => '🍰', 'Porciones' => 8, 'CostoEstimado' => 28.00,
                'Ingredientes' => [
                    (object)['IngredienteNombre' => 'Harina de trigo', 'Cantidad' => 200, 'Unidad' => 'g'],
                    (object)['IngredienteNombre' => 'Mantequilla', 'Cantidad' => 120, 'Unidad' => 'g'],
                    (object)['IngredienteNombre' => 'Azúcar refinada', 'Cantidad' => 180, 'Unidad' => 'g']
                ]
            ],
        ];

        $movimientos = [
            (object)['Id' => 1, 'IngredienteNombre' => 'Café espresso molido', 'Tipo' => 'Entrada', 'IconTipo' => 'move_to_inbox', 'ColorTipo' => '#10b981', 'Cantidad' => 2000, 'Unidad' => 'g', 'Motivo' => 'Compra a proveedor', 'UsuarioNombre' => 'Admin', 'Fecha' => now()->subDays(1)],
            (object)['Id' => 2, 'IngredienteNombre' => 'Leche entera', 'Tipo' => 'Entrada', 'IconTipo' => 'move_to_inbox', 'ColorTipo' => '#10b981', 'Cantidad' => 10, 'Unidad' => 'L', 'Motivo' => 'Entrega semanal', 'UsuarioNombre' => 'Admin', 'Fecha' => now()->subDays(1)],
            (object)['Id' => 3, 'IngredienteNombre' => 'Harina de trigo', 'Tipo' => 'Salida', 'IconTipo' => 'outbox', 'ColorTipo' => '#ef4444', 'Cantidad' => -0.8, 'Unidad' => 'kg', 'Motivo' => 'Producción pasteles', 'UsuarioNombre' => 'Admin', 'Fecha' => now()->subHours(3)],
            (object)['Id' => 4, 'IngredienteNombre' => 'Canela en polvo', 'Tipo' => 'Ajuste', 'IconTipo' => 'tune', 'ColorTipo' => '#f59e0b', 'Cantidad' => -5, 'Unidad' => 'g', 'Motivo' => 'Conteo físico', 'UsuarioNombre' => 'Admin', 'Fecha' => now()->subHours(2)],
        ];

        // 5. Conteos (Mock Data)
        $conteos = [
            (object)['Id' => 1, 'Nombre' => 'Conteo Semanal – Jul 7', 'Estado' => 'Completado', 'ColorEstado' => '#10b981', 'UsuarioNombre' => 'Admin', 'Fecha' => now()->subDays(2), 'TotalItems' => 10, 'ItemsContados' => 10, 'Progreso' => 100],
            (object)['Id' => 2, 'Nombre' => 'Conteo Urgente Lácteos', 'Estado' => 'Completado', 'ColorEstado' => '#10b981', 'UsuarioNombre' => 'Admin', 'Fecha' => now()->subDays(1), 'TotalItems' => 3, 'ItemsContados' => 3, 'Progreso' => 100],
            (object)['Id' => 3, 'Nombre' => 'Conteo Semanal – Jul 14', 'Estado' => 'EnProgreso', 'ColorEstado' => '#f59e0b', 'UsuarioNombre' => 'Admin', 'Fecha' => now(), 'TotalItems' => 10, 'ItemsContados' => 4, 'Progreso' => 40],
        ];

        // 6. Proveedores (Mock Data)
        $proveedores = [
            (object)['Id' => 1, 'Nombre' => 'Café Origen SLP', 'Contacto' => 'Luis Vega', 'Telefono' => '444-100-2000', 'Email' => 'ventas@cafenorigen.mx', 'Ciudad' => 'San Luis Potosí', 'Activo' => true, 'IngredientesProveidos' => 3],
            (object)['Id' => 2, 'Nombre' => 'Lácteos San Miguel', 'Contacto' => 'Rosa Peña', 'Telefono' => '444-200-3000', 'Email' => 'pedidos@lacteossm.mx', 'Ciudad' => 'San Luis Potosí', 'Activo' => true, 'IngredientesProveidos' => 3],
            (object)['Id' => 3, 'Nombre' => 'Insumos Bakery Pro', 'Contacto' => 'Gerardo Díaz', 'Telefono' => '444-300-4000', 'Email' => 'contacto@bakerysupply.mx', 'Ciudad' => 'Guadalajara', 'Activo' => true, 'IngredientesProveidos' => 4],
            (object)['Id' => 4, 'Nombre' => 'Especias del Norte', 'Contacto' => 'Carmen Gil', 'Telefono' => '444-400-5000', 'Email' => 'especias@norte.mx', 'Ciudad' => 'Monterrey', 'Activo' => false, 'IngredientesProveidos' => 1],
        ];

        $alertasBajoStock = count(array_filter($ingredientes, fn($i) => $i->AlertaBajoStock));
        $tabActiva = $request->query('tab', 'productos');

        return view('inventory', compact(
            'productos',
            'ingredientes',
            'recetas',
            'movimientos',
            'conteos',
            'proveedores',
            'alertasBajoStock',
            'tabActiva'
        ));
    }

    public function storeProduct(Request $request)
    {
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
            'category_id' => 1,
            'name' => $request->input('name'),
            'base_price' => $request->input('base_price'),
            'stock' => $request->input('stock', 0),
            'emoji' => $request->input('emoji', '☕'),
            'description' => $request->input('description', 'Producto registrado en inventario'),
            'is_active' => 1,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('inventory')->with('success', 'Producto creado con éxito.');
    }

    public function updateProduct(Request $request)
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
            'stock' => $request->input('stock', 0),
            'emoji' => $request->input('emoji', '☕'),
            'description' => $request->input('description'),
            'is_active' => $request->has('is_active') ? 1 : 0,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('inventory')->with('success', 'Producto "' . $product->name . '" actualizado con éxito.');
    }
}
