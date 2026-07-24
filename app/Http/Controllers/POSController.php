<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class POSController extends Controller
{
    public function index(Request $request)
    {
        $categoriaActiva = $request->query('cat', 'todos');
        $busqueda = $request->query('q', '');
        $sort = $request->query('sort', 'name_asc');
        $featured = $request->query('featured', '0');

        $query = \App\Models\Product::where('is_active', 1);

        if ($categoriaActiva !== 'todos') {
            $catId = DB::table('categories')->where('slug', $categoriaActiva)->value('id');
            if ($catId) {
                $query->where('category_id', $catId);
            }
        }

        if ($busqueda) {
            $query->where('name', 'like', '%' . $busqueda . '%');
        }
        
        if ($featured == '1') {
            $query->where('is_featured', 1);
        }
        
        if ($sort == 'price_asc') {
            $query->orderBy('base_price', 'asc');
        } elseif ($sort == 'price_desc') {
            $query->orderBy('base_price', 'desc');
        } else {
            $query->orderBy('name', 'asc');
        }

        $products = $query->get();
        
        // Determinar si los productos están agotados y si tienen promociones activas (Sprint 4 & Sprint 7)
        $branchId = DB::table('branches')->first()->id ?? 1;
        $activePromotions = \App\Models\Promotion::where('is_active', 1)->get();

        foreach ($products as $product) {
            $isOutOfStock = false;
            
            $recipe = \App\Models\Recipe::where('product_id', $product->id)->first();
            if ($recipe) {
                $recipeItems = \App\Models\RecipeItem::where('recipe_id', $recipe->id)->get();
                foreach ($recipeItems as $item) {
                    $stock = \App\Models\InventoryItem::where('branch_id', $branchId)
                        ->where('ingredient_id', $item->ingredient_id)
                        ->sum('quantity_on_hand');
                        
                    if ($stock < $item->quantity) {
                        $isOutOfStock = true;
                        break;
                    }
                }
            } else {
                // Producto directo sin receta (ej. Pastel)
                $stock = \App\Models\InventoryItem::where('branch_id', $branchId)
                    ->where('product_id', $product->id)
                    ->sum('quantity_on_hand');
                    
                if ($stock < 1) {
                    $isOutOfStock = true;
                }
            }
            $product->is_out_of_stock = $isOutOfStock;

            // Promoción activa aplicable (Sprint 7)
            $discountedPrice = $product->base_price;
            $hasPromotion = false;
            $promotionBadge = null;

            foreach ($activePromotions as $promo) {
                $applies = false;
                if ($promo->applies_to === 'all') {
                    $applies = true;
                } elseif ($promo->applies_to === 'product' && $promo->target_id == $product->id) {
                    $applies = true;
                } elseif ($promo->applies_to === 'category' && $promo->target_id == $product->category_id) {
                    $applies = true;
                }

                if ($applies) {
                    $hasPromotion = true;
                    if ($promo->discount_type === 'percentage') {
                        $discount = ($product->base_price * $promo->discount_value) / 100;
                        $discountedPrice = max(0, $product->base_price - $discount);
                        $promotionBadge = intval($promo->discount_value) . '% OFF';
                    } elseif ($promo->discount_type === 'fixed_amount') {
                        $discountedPrice = max(0, $product->base_price - $promo->discount_value);
                        $promotionBadge = '-$' . number_format($promo->discount_value, 0) . ' OFF';
                    }
                    break;
                }
            }

            $product->discounted_price = $discountedPrice;
            $product->has_promotion = $hasPromotion;
            $product->promotion_badge = $promotionBadge;
        }

        $cart = $request->session()->get('pos_cart', []);
        $cartCount = 0;
        foreach ($cart as $item) {
            $cartCount += $item['quantity'];
        }

        $hasActiveCashSession = true;

        $dailyMealsCategory = DB::table('categories')->where('slug', 'comidas-del-dia')->first();
        $dailyMeals = [];
        if ($dailyMealsCategory) {
            $dailyMeals = \App\Models\Product::where('category_id', $dailyMealsCategory->id)
                ->where('is_active', 1)
                ->get();
        }

        return view('pos.index', [
            'products' => $products,
            'dailyMeals' => $dailyMeals,
            'categoriaActiva' => $categoriaActiva,
            'busqueda' => $busqueda,
            'sort' => $sort,
            'featured' => $featured,
            'cartCount' => $cartCount,
            'hasActiveCashSession' => $hasActiveCashSession
        ]);
    }

    public function cart(Request $request)
    {
        $cart = $request->session()->get('pos_cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['total_price'] * $item['quantity'];
        }

        $userId = 1; // Simulated auth user
        $hasActiveCashSession = DB::table('cash_sessions')
            ->where('user_id', $userId)
            ->where('status', 'open')
            ->exists();
        $customers = \App\Models\Customer::orderBy('name')->get();
        
        return view('pos.cart', compact('cart', 'total', 'hasActiveCashSession', 'customers'));
    }

    public function getCart(Request $request)
    {
        $cart = $request->session()->get('pos_cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['total_price'] * $item['quantity'];
        }
        return response()->json(['cart' => $cart, 'total' => $total]);
    }

    public function addToCart(Request $request)
    {
        $product = \App\Models\Product::findOrFail($request->input('product_id'));
        $cart = $request->session()->get('pos_cart', []);
        
        $modifiers = $request->input('modifiers', []);
        
        // Calcular precio promocional por defecto si no viene especificado en request
        $defaultPrice = $product->base_price;
        $activePromo = \App\Models\Promotion::where('is_active', 1)
            ->where(function($q) use ($product) {
                $q->where('applies_to', 'all')
                  ->orWhere(function($q2) use ($product) {
                      $q2->where('applies_to', 'product')->where('target_id', $product->id);
                  })
                  ->orWhere(function($q3) use ($product) {
                      $q3->where('applies_to', 'category')->where('target_id', $product->category_id);
                  });
            })->first();

        if ($activePromo) {
            if ($activePromo->discount_type === 'percentage') {
                $discount = ($product->base_price * $activePromo->discount_value) / 100;
                $defaultPrice = max(0, $product->base_price - $discount);
            } elseif ($activePromo->discount_type === 'fixed_amount') {
                $defaultPrice = max(0, $product->base_price - $activePromo->discount_value);
            }
        }

        $totalPrice = $request->input('total_price', $defaultPrice);
        
        // Generar un ID único para esta línea del carrito basado en el producto y sus modificadores
        $lineId = $product->id . '_' . md5(json_encode($modifiers));
        
        if (isset($cart[$lineId])) {
            $cart[$lineId]['quantity'] += 1;
        } else {
            $cart[$lineId] = [
                'line_id' => $lineId,
                'product_id' => $product->id,
                'name' => $product->name,
                'base_price' => $defaultPrice,
                'total_price' => $totalPrice,
                'quantity' => 1,
                'modifiers' => $modifiers,
                'image' => $product->image,
                'emoji' => $product->emoji,
            ];
        }
        
        $request->session()->put('pos_cart', $cart);
        
        return response()->json(['success' => true, 'cart' => array_values($cart)]);
    }

    public function removeFromCart(Request $request)
    {
        $lineId = $request->input('line_id');
        $cart = $request->session()->get('pos_cart', []);
        
        if (isset($cart[$lineId])) {
            unset($cart[$lineId]);
            $request->session()->put('pos_cart', $cart);
        }
        
        return response()->json(['success' => true]);
    }

    public function clearCart(Request $request)
    {
        $request->session()->forget('pos_cart');
        return response()->json(['success' => true]);
    }
}
