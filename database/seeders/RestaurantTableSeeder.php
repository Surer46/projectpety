<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\RestaurantArea;
use Carbon\Carbon;

class RestaurantTableSeeder extends Seeder
{
    /**
     * Áreas físicas hipotéticas de la Cafetería PETY.
     * Cada área tiene un ambiente y capacidad diferente.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Mapear los nombres de áreas a sus IDs
        $areaMap = RestaurantArea::pluck('id', 'name')->toArray();

        $mesas = [
            // ─── ÁREA 1: Comedor Principal (Interior) ────────────────────────────
            ['table_number' => 'Mesa 01', 'area' => 'Comedor Principal', 'capacity' => 2, 'status' => 'libre'],
            ['table_number' => 'Mesa 02', 'area' => 'Comedor Principal', 'capacity' => 2, 'status' => 'ocupada'],
            ['table_number' => 'Mesa 03', 'area' => 'Comedor Principal', 'capacity' => 4, 'status' => 'libre'],
            ['table_number' => 'Mesa 04', 'area' => 'Comedor Principal', 'capacity' => 4, 'status' => 'reservada',
             'customer_name' => 'Laura Ramírez', 'customer_phone' => '442-111-2233', 'reservation_time' => '14:00', 'party_size' => 3],
            ['table_number' => 'Mesa 05', 'area' => 'Comedor Principal', 'capacity' => 4, 'status' => 'libre'],
            ['table_number' => 'Mesa 06', 'area' => 'Comedor Principal', 'capacity' => 6, 'status' => 'libre'],
            ['table_number' => 'Mesa 07', 'area' => 'Comedor Principal', 'capacity' => 6, 'status' => 'ocupada'],

            // ─── ÁREA 2: Terraza Exterior ─────────────────────────────────────────
            ['table_number' => 'Terraza T-01', 'area' => 'Terraza Exterior', 'capacity' => 2, 'status' => 'libre'],
            ['table_number' => 'Terraza T-02', 'area' => 'Terraza Exterior', 'capacity' => 2, 'status' => 'libre'],
            ['table_number' => 'Terraza T-03', 'area' => 'Terraza Exterior', 'capacity' => 4, 'status' => 'reservada',
             'customer_name' => 'Grupo Empresarial NovaTech', 'customer_phone' => '442-555-9900', 'reservation_time' => '13:30', 'party_size' => 4],
            ['table_number' => 'Terraza T-04', 'area' => 'Terraza Exterior', 'capacity' => 4, 'status' => 'libre'],
            ['table_number' => 'Terraza T-05', 'area' => 'Terraza Exterior', 'capacity' => 6, 'status' => 'libre'],

            // ─── ÁREA 3: Zona VIP / Privada ──────────────────────────────────────
            ['table_number' => 'VIP V-01', 'area' => 'Zona VIP / Privada', 'capacity' => 4, 'status' => 'libre'],
            ['table_number' => 'VIP V-02', 'area' => 'Zona VIP / Privada', 'capacity' => 6, 'status' => 'reservada',
             'customer_name' => 'Oscar Dueño', 'customer_phone' => '442-100-0001', 'reservation_time' => '20:00', 'party_size' => 5,
             'notes' => 'Aniversario de empresa. Solicitan decoración especial.'],
            ['table_number' => 'VIP V-03', 'area' => 'Zona VIP / Privada', 'capacity' => 8, 'status' => 'libre'],
            ['table_number' => 'VIP Salón Privado', 'area' => 'Zona VIP / Privada', 'capacity' => 12, 'status' => 'libre',
             'notes' => 'Sala de juntas con pantalla y proyector. Min. consumo $2,500 MXN.'],

            // ─── ÁREA 4: Barra / Counter ─────────────────────────────────────────
            ['table_number' => 'Barra B-01', 'area' => 'Barra / Counter',  'capacity' => 1, 'status' => 'ocupada'],
            ['table_number' => 'Barra B-02', 'area' => 'Barra / Counter',  'capacity' => 1, 'status' => 'libre'],
            ['table_number' => 'Barra B-03', 'area' => 'Barra / Counter',  'capacity' => 1, 'status' => 'libre'],
            ['table_number' => 'Barra B-04', 'area' => 'Barra / Counter',  'capacity' => 2, 'status' => 'libre'],

            // ─── ÁREA 5: Jardín Interior ─────────────────────────────────────────
            ['table_number' => 'Jardín J-01', 'area' => 'Jardín Interior',  'capacity' => 2, 'status' => 'libre'],
            ['table_number' => 'Jardín J-02', 'area' => 'Jardín Interior',  'capacity' => 4, 'status' => 'libre'],
            ['table_number' => 'Jardín J-03', 'area' => 'Jardín Interior',  'capacity' => 4, 'status' => 'limpieza'],
            ['table_number' => 'Jardín J-04', 'area' => 'Jardín Interior',  'capacity' => 6, 'status' => 'libre'],
        ];

        foreach ($mesas as $mesa) {
            $areaId = $areaMap[$mesa['area']] ?? null;
            DB::table('restaurant_tables')->insert(array_merge($mesa, [
                'area_id'    => $areaId,
                'created_at' => $now,
                'updated_at' => $now,
            ]));
        }
    }
}
