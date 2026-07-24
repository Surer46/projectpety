<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // 1. Roles
        $ownerRoleId = DB::table('roles')->insertGetId([
            'name' => 'dueño',
            'guard_name' => 'web',
            'description' => 'Dueño Supremo del Sistema - Inmutable',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $adminRoleId = DB::table('roles')->insertGetId([
            'name' => 'administrador', // We keep this as 'administrador' per prompt instructions but Laura Gerente gets 'gerente' role or we create 'gerente'.
            'guard_name' => 'web',
            'description' => 'Administrador de Sucursal',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $gerenteRoleId = DB::table('roles')->insertGetId([
            'name' => 'gerente',
            'guard_name' => 'web',
            'description' => 'Gerente de Sucursal',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $cajeroRoleId = DB::table('roles')->insertGetId([
            'name' => 'cajero',
            'guard_name' => 'web',
            'description' => 'Operador de Punto de Venta',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $cocinaRoleId = DB::table('roles')->insertGetId([
            'name' => 'cocina',
            'guard_name' => 'web',
            'description' => 'Personal de Cocina y Preparación',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $almacenRoleId = DB::table('roles')->insertGetId([
            'name' => 'almacen',
            'guard_name' => 'web',
            'description' => 'Encargado de Inventario',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 2. Usuarios
        // Oscar Dueño
        $oscarId = DB::table('users')->insertGetId([
            'name' => 'Oscar Dueño',
            'username' => 'oscar.dueno',
            'email' => 'oscar@cafeteriapety.com',
            'password' => Hash::make('password123'),
            'is_active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('model_has_roles')->insert([
            'role_id' => $ownerRoleId,
            'model_type' => 'App\Models\User',
            'model_id' => $oscarId,
        ]);

        // Laura Gerente
        $lauraId = DB::table('users')->insertGetId([
            'name' => 'Laura Gerente',
            'username' => 'laura.gerente',
            'email' => 'laura@cafeteriapety.com',
            'password' => Hash::make('password123'),
            'is_active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('model_has_roles')->insert([
            'role_id' => $gerenteRoleId,
            'model_type' => 'App\Models\User',
            'model_id' => $lauraId,
        ]);

        // Cajero
        $cajeroId = DB::table('users')->insertGetId([
            'name' => 'Carlos Cajero',
            'username' => 'carlos.cajero',
            'email' => 'carlos@cafeteriapety.com',
            'password' => Hash::make('password123'),
            'is_active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('model_has_roles')->insert([
            'role_id' => $cajeroRoleId,
            'model_type' => 'App\Models\User',
            'model_id' => $cajeroId,
        ]);

        // Cocinero
        $cocinaId = DB::table('users')->insertGetId([
            'name' => 'Maria Cocina',
            'username' => 'maria.cocina',
            'email' => 'maria@cafeteriapety.com',
            'password' => Hash::make('password123'),
            'is_active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('model_has_roles')->insert([
            'role_id' => $cocinaRoleId,
            'model_type' => 'App\Models\User',
            'model_id' => $cocinaId,
        ]);

        // Almacen
        $almacenId = DB::table('users')->insertGetId([
            'name' => 'Pedro Almacen',
            'username' => 'pedro.almacen',
            'email' => 'pedro@cafeteriapety.com',
            'password' => Hash::make('password123'),
            'is_active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('model_has_roles')->insert([
            'role_id' => $almacenRoleId,
            'model_type' => 'App\Models\User',
            'model_id' => $almacenId,
        ]);

        // Cliente
        DB::table('users')->insertGetId([
            'name' => 'Juan Pérez (Cliente)',
            'username' => 'juan.perez',
            'email' => 'juan.perez@example.com',
            'password' => Hash::make('password123'),
            'is_active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 3. Sucursal 'Cafeteria PETY'
        DB::table('branches')->insert([
            'name' => 'Cafeteria PETY',
            'legal_name' => 'Cafeteria PETY',
            'phone' => '555-010-0202',
            'email' => 'contacto@cafeteriapety.com',
            'address' => 'Av. Principal 123, Centro',
            'city' => 'Ciudad de Mexico',
            'currency_code' => 'MXN',
            'timezone' => 'America/Mexico_City',
            'is_active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 4. Categorías
        $catCafesId = DB::table('categories')->insertGetId([
            'name' => 'Cafés',
            'slug' => 'cafes',
            'is_active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $catEspecialesId = DB::table('categories')->insertGetId([
            'name' => 'Especialidades',
            'slug' => 'especiales',
            'is_active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $catPastelesId = DB::table('categories')->insertGetId([
            'name' => 'Pasteles & Dulces',
            'slug' => 'pasteles',
            'is_active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 5. Productos con Descripciones Detalladas
        DB::table('products')->insert([
            [
                'category_id' => $catCafesId,
                'name' => 'Café Americano Premium',
                'slug' => 'cafe-americano-premium',
                'description' => 'Un clásico atemporal preparado con nuestra mezcla exclusiva de granos 100% arábica tostados al punto medio. Ofrece notas sutiles de caramelo y un aroma intenso para despertar tus sentidos.',
                'emoji' => '☕',
                'base_price' => 45.00,
                'product_type' => 'finished',
                'allow_modifiers' => 1,
                'is_featured' => 1,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category_id' => $catPastelesId,
                'name' => 'Pastel de Chocolate Oscuro',
                'slug' => 'pastel-chocolate-oscuro',
                'description' => 'Una porción decadente de suave bizcocho de chocolate envuelto en un ganache sedoso de cacao al 70%. El equilibrio perfecto entre lo dulce y lo amargo.',
                'emoji' => '🍰',
                'base_price' => 85.00,
                'product_type' => 'finished',
                'allow_modifiers' => 0,
                'is_featured' => 1,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category_id' => $catEspecialesId,
                'name' => 'Frappé Caramelo Macchiato',
                'slug' => 'frappe-caramelo-macchiato',
                'description' => 'Refrescante bebida licuada a base de leche, hielo, jarabe de vainilla y un toque de café espresso, coronada con crema batida y líneas de auténtico caramelo tostado.',
                'emoji' => '🥤',
                'base_price' => 95.00,
                'product_type' => 'finished',
                'allow_modifiers' => 1,
                'is_featured' => 1,
                'is_active' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);

        $this->call([
            InventorySeeder::class,
            CustomerSeeder::class,
            DailyMealsSeeder::class,
            PromotionSeeder::class,
            OrderSeeder::class,
            RestaurantAreaSeeder::class,
            RestaurantTableSeeder::class,
        ]);
    }
}
