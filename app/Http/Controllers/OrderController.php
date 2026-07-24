<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Processes a checkout from the POS.
     * Expects a JSON payload with:
     * {
     *   "cart": [ { "id": 1, "name": "...", "price": 45, "quantity": 1, "modifiers": {...} } ],
     *   "payment": { "method": "cash", "amount_tendered": 100 }
     * }
     */
    public function checkout(Request $request)
    {
        try {
            $data = $request->json()->all();
            $cart = $request->session()->get('pos_cart', []);
            
            if (empty($cart)) {
                return response()->json(['success' => false, 'message' => 'El carrito está vacío.'], 400);
            }

            // Calculate totals
            $cartSubtotal = 0;
            foreach ($cart as $item) {
                // Now using trusted session data
                $cartSubtotal += ($item['total_price'] * $item['quantity']);
            }
            
            $userId = 1; // Hardcoded to admin user for now
            
            $activeSession = DB::table('cash_sessions')
                ->where('user_id', $userId)
                ->where('status', 'open')
                ->first();

            $cashSessionId = $activeSession ? $activeSession->id : null;

            DB::beginTransaction();

            // Sprint 5: Fidelidad y Redención de Puntos de Clientes
            $customerId = $request->input('customer_id');
            $pointsRedeemed = (int) $request->input('points_redeemed', 0);
            $customerName = 'Mostrador';
            $discountAmount = 0;
            $customer = null;

            if ($customerId) {
                $customer = \App\Models\Customer::find($customerId);
                if ($customer) {
                    $customerName = $customer->name;
                    if ($pointsRedeemed > 0) {
                        $pointsToDeduct = min($pointsRedeemed, $customer->loyalty_points, (int) floor($cartSubtotal));
                        if ($pointsToDeduct > 0) {
                            $discountAmount = $pointsToDeduct * 1.0;
                            $customer->loyalty_points -= $pointsToDeduct;
                        }
                    }
                } else {
                    $customerId = null;
                }
            }

            $totalAmount = max(0, $cartSubtotal - $discountAmount);
            $subtotal = $totalAmount / 1.16;
            $taxAmount = $totalAmount - $subtotal;

            if ($customerId && $customer) {
                $pointsEarned = floor($totalAmount / 10);
                $customer->loyalty_points += $pointsEarned;
                $customer->save();
            }

            $paymentData = $data['payment'] ?? ['method' => 'cash', 'amount_tendered' => $totalAmount];
            $amountTendered = $paymentData['amount_tendered'];
            $changeReturned = max(0, $amountTendered - $totalAmount);

            // 1. Create Order
            $orderId = DB::table('orders')->insertGetId([
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'user_id' => $userId,
                'cash_session_id' => $cashSessionId,
                'customer_id' => $customerId,
                'customer_name' => $customerName,
                'order_type' => 'takeout',
                'status' => 'in_preparation',
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'discount_amount' => $discountAmount,
                'total_amount' => $totalAmount,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 2. Create Order Items and Deduct Inventory
            $branchId = DB::table('branches')->first()->id ?? 1;
            
            foreach ($cart as $item) {
                DB::table('order_items')->insert([
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'] ?? null,
                    'product_name' => $item['name'] ?? 'Producto Generico',
                    'quantity' => $item['quantity'] ?? 1,
                    'unit_price' => $item['total_price'] ?? 0,
                    'total_price' => ($item['total_price'] ?? 0) * ($item['quantity'] ?? 1),
                    'modifiers' => isset($item['modifiers']) ? json_encode($item['modifiers']) : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Inventory Deduction Logic (Sprint 4)
                if (isset($item['product_id'])) {
                    $product = \App\Models\Product::find($item['product_id']);
                    if ($product) {
                        $recipe = \App\Models\Recipe::where('product_id', $product->id)->first();
                        $qtySold = $item['quantity'] ?? 1;
                        
                        if ($recipe) {
                            $recipeItems = \App\Models\RecipeItem::where('recipe_id', $recipe->id)->get();
                            foreach ($recipeItems as $ri) {
                                $invItem = \App\Models\InventoryItem::where('branch_id', $branchId)
                                    ->where('ingredient_id', $ri->ingredient_id)->first();
                                
                                if ($invItem) {
                                    $totalDeduct = $ri->quantity * $qtySold;
                                    if ($invItem->quantity_on_hand < $totalDeduct) {
                                        throw new \Exception("Stock insuficiente para preparar " . $product->name);
                                    }
                                    $invItem->quantity_on_hand -= $totalDeduct;
                                    $invItem->save();

                                    \App\Models\InventoryMovement::create([
                                        'branch_id' => $branchId,
                                        'inventory_item_id' => $invItem->id,
                                        'user_id' => $userId,
                                        'movement_type' => 'sale',
                                        'quantity' => -$totalDeduct,
                                        'reference_type' => 'order',
                                        'reference_id' => $orderId,
                                        'reason' => 'Venta POS',
                                        'occurred_at' => now(),
                                    ]);
                                }
                            }
                        } else {
                            $invItem = \App\Models\InventoryItem::where('branch_id', $branchId)
                                ->where('product_id', $product->id)->first();
                                
                            if ($invItem) {
                                if ($invItem->quantity_on_hand < $qtySold) {
                                    throw new \Exception("Stock insuficiente para " . $product->name);
                                }
                                $invItem->quantity_on_hand -= $qtySold;
                                $invItem->save();

                                \App\Models\InventoryMovement::create([
                                    'branch_id' => $branchId,
                                    'inventory_item_id' => $invItem->id,
                                    'user_id' => $userId,
                                    'movement_type' => 'sale',
                                    'quantity' => -$qtySold,
                                    'reference_type' => 'order',
                                    'reference_id' => $orderId,
                                    'reason' => 'Venta POS',
                                    'occurred_at' => now(),
                                ]);
                            }
                        }
                    }
                }
            }

            // 3. Create Payment
            DB::table('payments')->insert([
                'order_id' => $orderId,
                'payment_method' => $paymentData['method'],
                'amount_paid' => $totalAmount,
                'amount_tendered' => $amountTendered,
                'change_returned' => $changeReturned,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            // Clear the cart
            $request->session()->forget('pos_cart');

            return response()->json([
                'success' => true,
                'message' => 'Orden procesada con éxito.',
                'order_id' => $orderId,
                'change' => $changeReturned
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error processing checkout: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Hubo un error procesando el cobro: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Sincroniza órdenes procesadas localmente en modo Offline (Sprint 6)
     */
    public function syncOffline(Request $request)
    {
        $orders = $request->input('orders', []);
        $syncedCount = 0;
        $userId = 1;

        $activeSession = DB::table('cash_sessions')
            ->where('user_id', $userId)
            ->where('status', 'open')
            ->first();

        $sessionId = $activeSession ? $activeSession->id : null;

        foreach ($orders as $orderData) {
            try {
                DB::beginTransaction();

                $customerId = $orderData['customer_id'] ?? null;
                $pointsRedeemed = (int) ($orderData['points_redeemed'] ?? 0);
                $rawTotal = (float) ($orderData['original_total'] ?? ($orderData['total'] ?? 0));
                $discountAmount = 0;
                $customerName = 'Mostrador (Offline)';
                $customer = null;

                if ($customerId) {
                    $customer = \App\Models\Customer::find($customerId);
                    if ($customer) {
                        $customerName = $customer->name;
                        if ($pointsRedeemed > 0) {
                            $pointsToDeduct = min($pointsRedeemed, $customer->loyalty_points, (int) floor($rawTotal));
                            if ($pointsToDeduct > 0) {
                                $discountAmount = $pointsToDeduct * 1.0;
                                $customer->loyalty_points -= $pointsToDeduct;
                            }
                        }
                    }
                }

                $totalAmount = max(0, $rawTotal - $discountAmount);
                $subtotal = $totalAmount / 1.16;
                $taxAmount = $totalAmount - $subtotal;

                if ($customerId && $customer) {
                    $customer->loyalty_points += floor($totalAmount / 10);
                    $customer->save();
                }

                $orderId = DB::table('orders')->insertGetId([
                    'order_number' => 'ORD-OFF-' . strtoupper(uniqid()),
                    'user_id' => $userId,
                    'cash_session_id' => $sessionId,
                    'customer_id' => $customerId,
                    'customer_name' => $customerName,
                    'order_type' => 'takeout',
                    'status' => 'completed',
                    'subtotal' => $subtotal,
                    'tax_amount' => $taxAmount,
                    'discount_amount' => $discountAmount,
                    'total_amount' => $totalAmount,
                    'created_at' => $orderData['created_at'] ?? now(),
                    'updated_at' => now(),
                ]);

                if (isset($orderData['cart']) && is_array($orderData['cart'])) {
                    foreach ($orderData['cart'] as $item) {
                        DB::table('order_items')->insert([
                            'order_id' => $orderId,
                            'product_id' => $item['product_id'] ?? null,
                            'product_name' => $item['name'] ?? 'Producto Generico',
                            'quantity' => $item['quantity'] ?? 1,
                            'unit_price' => $item['total_price'] ?? 0,
                            'total_price' => ($item['total_price'] ?? 0) * ($item['quantity'] ?? 1),
                            'modifiers' => isset($item['modifiers']) ? json_encode($item['modifiers']) : null,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }

                DB::table('payments')->insert([
                    'order_id' => $orderId,
                    'payment_method' => $orderData['payment']['method'] ?? 'cash',
                    'amount_paid' => $totalAmount,
                    'amount_tendered' => $orderData['payment']['amount_tendered'] ?? $totalAmount,
                    'change_returned' => max(0, ($orderData['payment']['amount_tendered'] ?? $totalAmount) - $totalAmount),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::commit();
                $syncedCount++;
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error syncing offline order: ' . $e->getMessage());
            }
        }

        return response()->json(['success' => true, 'synced_count' => $syncedCount]);
    }
}
