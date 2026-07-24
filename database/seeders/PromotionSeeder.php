<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PromotionSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $promotions = [
            [
                'name' => 'Oferta Especial Frappé (20% OFF)',
                'promotion_type' => 'automatic',
                'code' => 'FRAPPE20',
                'description' => '20% de descuento en Frappés y Especialidades frías',
                'applies_to' => 'category',
                'target_id' => DB::table('categories')->where('slug', 'especiales')->value('id'),
                'discount_type' => 'percentage',
                'discount_value' => 20.00,
                'minimum_order_amount' => 0.00,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Descuento Reposteria ($15.00 OFF)',
                'promotion_type' => 'automatic',
                'code' => 'DULCE15',
                'description' => '$15 pesos de descuento directo en pasteles y dulces',
                'applies_to' => 'category',
                'target_id' => DB::table('categories')->where('slug', 'pasteles')->value('id'),
                'discount_type' => 'fixed_amount',
                'discount_value' => 15.00,
                'minimum_order_amount' => 0.00,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ];

        foreach ($promotions as $promo) {
            $exists = DB::table('promotions')->where('name', $promo['name'])->exists();
            if (!$exists) {
                DB::table('promotions')->insert($promo);
            }
        }
    }
}
