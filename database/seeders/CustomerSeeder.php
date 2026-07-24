<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('customers')->insert([
            [
                'name' => 'Juan Pérez',
                'phone' => '555-019-2030',
                'email' => 'juan.perez@example.com',
                'loyalty_points' => 150,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'María Gómez',
                'phone' => '555-888-9999',
                'email' => 'maria.gomez@example.com',
                'loyalty_points' => 30,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Carlos Rodríguez',
                'phone' => '555-111-2222',
                'email' => 'carlos.r@example.com',
                'loyalty_points' => 500,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);
    }
}
