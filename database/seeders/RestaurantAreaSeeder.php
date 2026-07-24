<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RestaurantArea;
use App\Models\RestaurantTable;
use Illuminate\Support\Str;

class RestaurantAreaSeeder extends Seeder
{
    /**
     * Poblado de zonas/áreas físicas del establecimiento.
     */
    public function run(): void
    {
        $areas = [
            [
                'name'                 => 'Comedor Principal',
                'slug'                 => 'comedor-principal',
                'description'          => 'Salón central con iluminación tenue y cálida. Mesas de madera oscura.',
                'emoji'                => '🍽️',
                'icon'                 => 'chair',
                'color'                => '#c79c5e',
                'capacity'             => 28,
                'floor'                => 'Planta Baja',
                'schedule_open'        => '07:00',
                'schedule_close'       => '22:00',
                'is_outdoor'           => false,
                'requires_reservation' => false,
                'sort_order'           => 1,
                'is_active'            => true,
            ],
            [
                'name'                 => 'Terraza Exterior',
                'slug'                 => 'terraza-exterior',
                'description'          => 'Al aire libre con sombrillas y vegetación. Vista a la calle peatonal.',
                'emoji'                => '☀️',
                'icon'                 => 'deck',
                'color'                => '#34d399',
                'capacity'             => 18,
                'floor'                => 'Planta Baja (Exterior)',
                'schedule_open'        => '08:00',
                'schedule_close'       => '20:00',
                'is_outdoor'           => true,
                'requires_reservation' => false,
                'sort_order'           => 2,
                'is_active'            => true,
            ],
            [
                'name'                 => 'Zona VIP / Privada',
                'slug'                 => 'zona-vip',
                'description'          => 'Salón semi-privado separado por biombos artísticos. Audio ambiente personalizado.',
                'emoji'                => '💎',
                'icon'                 => 'diamond',
                'color'                => '#a78bfa',
                'capacity'             => 30,
                'floor'                => 'Planta Baja (Fondo)',
                'schedule_open'        => '12:00',
                'schedule_close'       => '22:00',
                'is_outdoor'           => false,
                'requires_reservation' => true,
                'min_consumption'      => 2500.00,
                'sort_order'           => 3,
                'is_active'            => true,
            ],
            [
                'name'                 => 'Barra / Counter',
                'slug'                 => 'barra-counter',
                'description'          => 'Asientos altos junto a la barra del barista. Vista directa al proceso del café.',
                'emoji'                => '☕',
                'icon'                 => 'local_cafe',
                'color'                => '#f59e0b',
                'capacity'             => 5,
                'floor'                => 'Planta Baja',
                'schedule_open'        => '07:00',
                'schedule_close'       => '22:00',
                'is_outdoor'           => false,
                'requires_reservation' => false,
                'sort_order'           => 4,
                'is_active'            => true,
            ],
            [
                'name'                 => 'Jardín Interior',
                'slug'                 => 'jardin-interior',
                'description'          => 'Patio cubierto con jardín vertical, luz natural filtrada y plantas tropicales.',
                'emoji'                => '🌿',
                'icon'                 => 'park',
                'color'                => '#4ade80',
                'capacity'             => 16,
                'floor'                => 'Planta Baja (Patio)',
                'schedule_open'        => '07:00',
                'schedule_close'       => '18:00',
                'is_outdoor'           => false,
                'requires_reservation' => false,
                'sort_order'           => 5,
                'is_active'            => true,
            ],
        ];

        foreach ($areas as $data) {
            $area = RestaurantArea::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );

            // Asignar area_id a las mesas existentes que coincidan en nombre
            RestaurantTable::where('area', $area->name)
                ->update(['area_id' => $area->id]);
        }
    }
}
