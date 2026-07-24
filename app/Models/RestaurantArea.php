<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RestaurantArea extends Model
{
    protected $fillable = [
        'branch_id', 'name', 'slug', 'description', 'emoji', 'icon', 'color',
        'capacity', 'floor', 'schedule_open', 'schedule_close',
        'is_outdoor', 'requires_reservation', 'min_consumption',
        'sort_order', 'is_active', 'notes'
    ];

    protected $casts = [
        'is_outdoor'           => 'boolean',
        'is_active'            => 'boolean',
        'requires_reservation' => 'boolean',
        'min_consumption'      => 'decimal:2',
    ];

    /**
     * Relación: Un área física pertenece a una sucursal.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    /**
     * Relación: Un área física posee múltiples mesas.
     */
    public function tables()
    {
        return $this->hasMany(RestaurantTable::class, 'area_id');
    }

    /**
     * Accesor: Cantidad de mesas disponibles (status = 'libre')
     */
    public function getAvailableTablesCountAttribute(): int
    {
        return $this->tables()->where('status', 'libre')->count();
    }

    /**
     * Accesor: Aforo máximo total calculado sumando sus mesas.
     */
    public function getTotalCapacityAttribute(): int
    {
        return $this->tables()->sum('capacity');
    }

    /**
     * Boot function para autogenerar slug al crear.
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($area) {
            if (empty($area->slug)) {
                $area->slug = Str::slug($area->name);
            }
        });
    }
}
