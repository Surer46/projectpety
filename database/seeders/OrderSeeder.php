<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $user = DB::table('users')->first();
        $userId = $user ? $user->id : 1;
        $session = DB::table('cash_sessions')->first();
        $sessionId = $session ? $session->id : 1;

        // Ensure products have image_path set with real Unsplash food/coffee images
        $images = [
            'cafe-americano-premium' => 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=500&auto=format&fit=crop',
            'pastel-chocolate-oscuro' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=500&auto=format&fit=crop',
            'frappe-caramelo-macchiato' => 'https://images.unsplash.com/photo-1572490122747-3968b75cc699?w=500&auto=format&fit=crop'
        ];

        foreach ($images as $slug => $img) {
            DB::table('products')->where('slug', $slug)->update(['image_path' => $img]);
        }

        // Add extra products if they don't exist
        $catCafes = DB::table('categories')->where('slug', 'cafes')->first();
        $catPasteles = DB::table('categories')->where('slug', 'pasteles')->first();
        $catEspeciales = DB::table('categories')->where('slug', 'especiales')->first();

        if ($catCafes) {
            DB::table('products')->updateOrInsert(
                ['slug' => 'capuchino-vainilla'],
                [
                    'category_id' => $catCafes->id,
                    'name' => 'Capuchino Vainilla Caramel',
                    'description' => 'Espresso doble con leche cremada al vapor y toque de caramelo.',
                    'emoji' => '☕',
                    'base_price' => 55.00,
                    'image_path' => 'https://images.unsplash.com/photo-1534778101976-62847782c213?w=500&auto=format&fit=crop',
                    'product_type' => 'finished',
                    'allow_modifiers' => 1,
                    'is_featured' => 1,
                    'is_active' => 1,
                    'created_at' => $now,
                    'updated_at' => $now
                ]
            );
        }

        if ($catPasteles) {
            DB::table('products')->updateOrInsert(
                ['slug' => 'croissant-almendras'],
                [
                    'category_id' => $catPasteles->id,
                    'name' => 'Croissant de Almendras',
                    'description' => 'Hojaldre mantequilla horneado diariamente con crema de almendras.',
                    'emoji' => '🥐',
                    'base_price' => 65.00,
                    'image_path' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=500&auto=format&fit=crop',
                    'product_type' => 'finished',
                    'allow_modifiers' => 0,
                    'is_featured' => 1,
                    'is_active' => 1,
                    'created_at' => $now,
                    'updated_at' => $now
                ]
            );
        }

        // Seed Active Orders (Mis Pedidos)
        // 1. Order in delivery (En Reparto)
        $order1 = DB::table('orders')->insertGetId([
            'order_number' => 'ORD-8942',
            'user_id' => $userId,
            'cash_session_id' => null,
            'customer_name' => 'Oscar Dueño',
            'order_type' => 'delivery',
            'status' => 'on_delivery',
            'subtotal' => 185.34,
            'tax_amount' => 29.66,
            'discount_amount' => 0.00,
            'total_amount' => 215.00,
            'created_at' => $now->copy()->subMinutes(18),
            'updated_at' => $now,
        ]);

        DB::table('order_items')->insert([
            [
                'order_id' => $order1,
                'product_name' => 'Frappé Caramelo Macchiato',
                'quantity' => 2,
                'unit_price' => 65.00,
                'total_price' => 130.00,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'order_id' => $order1,
                'product_name' => 'Pastel de Chocolate Oscuro',
                'quantity' => 1,
                'unit_price' => 85.00,
                'total_price' => 85.00,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);

        // 2. Order in preparation (En Preparación - Dine in)
        $order2 = DB::table('orders')->insertGetId([
            'order_number' => 'ORD-8943',
            'user_id' => $userId,
            'cash_session_id' => null,
            'customer_name' => 'Oscar Dueño',
            'order_type' => 'dine_in',
            'status' => 'in_preparation',
            'subtotal' => 112.07,
            'tax_amount' => 17.93,
            'discount_amount' => 0.00,
            'total_amount' => 130.00,
            'created_at' => $now->copy()->subMinutes(6),
            'updated_at' => $now,
        ]);

        DB::table('order_items')->insert([
            [
                'order_id' => $order2,
                'product_name' => 'Capuchino Vainilla Caramel',
                'quantity' => 1,
                'unit_price' => 55.00,
                'total_price' => 55.00,
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'order_id' => $order2,
                'product_name' => 'Croissant de Almendras',
                'quantity' => 1,
                'unit_price' => 75.00,
                'total_price' => 75.00,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);

        // Seed Completed Orders (Mis Compras)
        $order3 = DB::table('orders')->insertGetId([
            'order_number' => 'ORD-7812',
            'user_id' => $userId,
            'cash_session_id' => null,
            'customer_name' => 'Oscar Dueño',
            'order_type' => 'dine_in',
            'status' => 'completed',
            'subtotal' => 211.21,
            'tax_amount' => 33.79,
            'discount_amount' => 0.00,
            'total_amount' => 245.00,
            'created_at' => $now->copy()->subDays(2),
            'updated_at' => $now->copy()->subDays(2),
        ]);

        DB::table('order_items')->insert([
            [
                'order_id' => $order3,
                'product_name' => 'Café Americano Premium',
                'quantity' => 2,
                'unit_price' => 45.00,
                'total_price' => 90.00,
                'created_at' => $now->copy()->subDays(2),
                'updated_at' => $now->copy()->subDays(2)
            ],
            [
                'order_id' => $order3,
                'product_name' => 'Pastel de Chocolate Oscuro',
                'quantity' => 1,
                'unit_price' => 85.00,
                'total_price' => 85.00,
                'created_at' => $now->copy()->subDays(2),
                'updated_at' => $now->copy()->subDays(2)
            ]
        ]);

        $order4 = DB::table('orders')->insertGetId([
            'order_number' => 'ORD-7650',
            'user_id' => $userId,
            'cash_session_id' => null,
            'customer_name' => 'Oscar Dueño',
            'order_type' => 'delivery',
            'status' => 'completed',
            'subtotal' => 155.17,
            'tax_amount' => 24.83,
            'discount_amount' => 0.00,
            'total_amount' => 180.00,
            'created_at' => $now->copy()->subDays(5),
            'updated_at' => $now->copy()->subDays(5),
        ]);

        DB::table('order_items')->insert([
            [
                'order_id' => $order4,
                'product_name' => 'Frappé Caramelo Macchiato',
                'quantity' => 2,
                'unit_price' => 65.00,
                'total_price' => 130.00,
                'created_at' => $now->copy()->subDays(5),
                'updated_at' => $now->copy()->subDays(5)
            ],
            [
                'order_id' => $order4,
                'product_name' => 'Croissant de Almendras',
                'quantity' => 1,
                'unit_price' => 50.00,
                'total_price' => 50.00,
                'created_at' => $now->copy()->subDays(5),
                'updated_at' => $now->copy()->subDays(5)
            ]
        ]);
    }
}
