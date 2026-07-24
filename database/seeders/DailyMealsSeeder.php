<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DailyMealsSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // 1. Crear categoría 'Comidas del Día' si no existe
        $catComidas = DB::table('categories')->where('slug', 'comidas-del-dia')->first();
        if (!$catComidas) {
            $catId = DB::table('categories')->insertGetId([
                'name' => 'Comidas del Día',
                'slug' => 'comidas-del-dia',
                'description' => 'Platillos ejecutivos y comidas preparadas al momento',
                'icon' => 'restaurant',
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        } else {
            $catId = $catComidas->id;
        }

        // 2. Insertar Platillos del Día
        $meals = [
            [
                'category_id' => $catId,
                'name' => 'Menú Ejecutivo PETY',
                'slug' => 'menu-ejecutivo-pety',
                'description' => 'Sopa del día + Platillo Fuerte (Pechuga a la Plancha o Milanesa) + Arroz/Ensalada + Bebida fresca a elegir.',
                'emoji' => '🍽️',
                'base_price' => 145.00,
                'product_type' => 'finished',
                'allow_modifiers' => 1,
                'is_featured' => 1,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category_id' => $catId,
                'name' => 'Chilaquiles del Día con Pollo',
                'slug' => 'chilaquiles-del-dia-con-pollo',
                'description' => 'Totopos crujientes bañados en salsa verde especial o roja habanera, servidos con pechuga deshebrada, crema, queso fresco y frijoles refritos.',
                'emoji' => '🍲',
                'base_price' => 120.00,
                'product_type' => 'finished',
                'allow_modifiers' => 1,
                'is_featured' => 1,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category_id' => $catId,
                'name' => 'Pechuga Cordon Bleu con Ensalada',
                'slug' => 'pechuga-cordon-bleu-con-ensalada',
                'description' => 'Pechuga empapada y rellena de jamón de pavo y queso manchego derretido, acompañada de ensalada de la casa con aderezo moustaza-miel.',
                'emoji' => '🍗',
                'base_price' => 135.00,
                'product_type' => 'finished',
                'allow_modifiers' => 0,
                'is_featured' => 1,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ];

        foreach ($meals as $meal) {
            $exists = DB::table('products')->where('slug', $meal['slug'])->exists();
            if (!$exists) {
                DB::table('products')->insert($meal);
            }
        }
    }
}
