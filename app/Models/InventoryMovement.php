<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryMovement extends Model
{
    protected $guarded = ['id'];

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class);
    }
}
