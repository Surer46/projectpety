<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'restaurant_table_id',
        'area_id',
        'customer_name',
        'customer_phone',
        'reservation_date',
        'reservation_time',
        'party_size',
        'status',
        'notes',
        'cancelled_at',
        'completed_at',
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'cancelled_at'     => 'datetime',
        'completed_at'     => 'datetime',
    ];

    public function table()
    {
        return $this->belongsTo(RestaurantTable::class, 'restaurant_table_id');
    }

    public function area()
    {
        return $this->belongsTo(RestaurantArea::class, 'area_id');
    }
}
