<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('bienvenida');
});

Route::get('/bienvenida', function () {
    $featuredProducts = \App\Models\Product::with('category')->where('is_active', 1)->take(4)->get();
    return view('bienvenida', compact('featuredProducts'));
})->name('bienvenida');

use App\Http\Controllers\POSController;

Route::get('/ventas', [POSController::class, 'index'])->name('pos');
Route::get('/carrito', [POSController::class, 'cart'])->name('cart.index');
Route::post('/cart/add', [POSController::class, 'addToCart'])->name('cart.add');
Route::get('/cart/get', [POSController::class, 'getCart'])->name('cart.get');
Route::post('/cart/remove', [POSController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/clear', [POSController::class, 'clearCart'])->name('cart.clear');

use App\Http\Controllers\OrderController;
use App\Http\Controllers\MyOrdersController;
use App\Http\Controllers\PurchaseHistoryController;

Route::get('/mis-pedidos', [MyOrdersController::class, 'index'])->name('pedidos.index');
Route::post('/mis-pedidos/{id}/update-status', [MyOrdersController::class, 'updateStatus'])->name('pedidos.update-status');
Route::get('/mis-compras', [PurchaseHistoryController::class, 'index'])->name('compras.index');
Route::post('/orders/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
Route::post('/orders/sync-offline', [OrderController::class, 'syncOffline'])->name('orders.sync-offline');

// Redirección de compatibilidad tras remover el módulo administrativo de Caja
Route::get('/caja', function() {
    return redirect()->route('pos');
})->name('caja');

use App\Http\Controllers\InventoryController;

Route::get('/inventario', [InventoryController::class, 'index'])->name('inventory');
Route::post('/inventario/productos/store', [InventoryController::class, 'storeProduct'])->name('inventory.products.store');
Route::post('/inventario/productos/update', [InventoryController::class, 'updateProduct'])->name('inventory.products.update');

use App\Http\Controllers\BackofficeController;

Route::get('/backoffice', [BackofficeController::class, 'index'])->name('backoffice');
Route::post('/backoffice/promotions', [BackofficeController::class, 'storePromotion'])->name('backoffice.promotions.store');
Route::post('/backoffice/promotions/{id}/toggle', [BackofficeController::class, 'togglePromotion'])->name('backoffice.promotions.toggle');
Route::post('/backoffice/daily-meals', [BackofficeController::class, 'storeDailyMeal'])->name('backoffice.daily-meals.store');
Route::post('/backoffice/daily-meals/{id}/toggle', [BackofficeController::class, 'toggleDailyMeal'])->name('backoffice.daily-meals.toggle');
Route::post('/backoffice/areas', [BackofficeController::class, 'storeArea'])->name('backoffice.areas.store');
Route::post('/backoffice/areas/{id}/update', [BackofficeController::class, 'updateArea'])->name('backoffice.areas.update');
Route::post('/backoffice/areas/{id}/toggle', [BackofficeController::class, 'toggleArea'])->name('backoffice.areas.toggle');
Route::post('/backoffice/areas/{id}/delete', [BackofficeController::class, 'destroyArea'])->name('backoffice.areas.destroy');
Route::post('/backoffice/tables', [BackofficeController::class, 'storeTable'])->name('backoffice.tables.store');
Route::post('/backoffice/tables/{id}/update', [BackofficeController::class, 'updateTable'])->name('backoffice.tables.update');
Route::post('/backoffice/tables/{id}/delete', [BackofficeController::class, 'destroyTable'])->name('backoffice.tables.destroy');
Route::post('/backoffice/orders/{id}/status', [BackofficeController::class, 'updateOrderStatus'])->name('backoffice.orders.status');

use App\Http\Controllers\PromotionsMealsController;

Route::get('/promociones-comidas', [PromotionsMealsController::class, 'index'])->name('promotions-meals.index');
Route::post('/promociones-comidas/promotions', [PromotionsMealsController::class, 'storePromotion'])->name('promotions-meals.promotions.store');
Route::post('/promociones-comidas/promotions/{id}/toggle', [PromotionsMealsController::class, 'togglePromotion'])->name('promotions-meals.promotions.toggle');
Route::post('/promociones-comidas/daily-meals', [PromotionsMealsController::class, 'storeDailyMeal'])->name('promotions-meals.daily-meals.store');
Route::post('/promociones-comidas/daily-meals/update', [PromotionsMealsController::class, 'updateDailyMeal'])->name('promotions-meals.daily-meals.update');
Route::post('/promociones-comidas/daily-meals/{id}/delete', [PromotionsMealsController::class, 'destroyDailyMeal'])->name('promotions-meals.daily-meals.delete');
Route::post('/promociones-comidas/daily-meals/{id}/toggle', [PromotionsMealsController::class, 'toggleDailyMeal'])->name('promotions-meals.daily-meals.toggle');
Route::post('/promociones-comidas/tables/{id}/occupy', [PromotionsMealsController::class, 'occupyTable'])->name('promotions-meals.tables.occupy');
Route::post('/promociones-comidas/tables/{id}/release', [PromotionsMealsController::class, 'releaseTable'])->name('promotions-meals.tables.release');

use App\Http\Controllers\CustomerSupportController;

Route::get('/atencion-cliente', [CustomerSupportController::class, 'index'])->name('atencion-cliente');
Route::post('/atencion-cliente/mensaje', [CustomerSupportController::class, 'sendMessage'])->name('atencion-cliente.message');

use App\Http\Controllers\ReservationController;

Route::get('/reservaciones', [ReservationController::class, 'index'])->name('reservaciones');
Route::post('/reservaciones/store', [ReservationController::class, 'store'])->name('reservaciones.store');
Route::post('/reservaciones/{id}/cancel', [ReservationController::class, 'cancel'])->name('reservaciones.cancel');

use App\Http\Controllers\SettingsController;

Route::get('/configuracion', [SettingsController::class, 'index'])->name('settings');

// Placeholder for auth routes
Route::middleware(['auth'])->group(function () {
    // We will move the routes here once the auth controllers are set up
});
