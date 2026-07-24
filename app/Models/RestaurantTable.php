<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantTable extends Model
{
    protected $fillable = [
        'table_number',
        'area',
        'area_id',
        'capacity',
        'status',
        'customer_name',
        'customer_phone',
        'reservation_time',
        'party_size',
        'notes',
    ];

    /**
     * Relación: Una mesa pertenece a un área física.
     */
    public function area()
    {
        return $this->belongsTo(RestaurantArea::class, 'area_id');
    }

    /**
     * Relación: Una mesa puede tener historial de reservas.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'restaurant_table_id');
    }
}
