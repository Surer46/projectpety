<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingredient extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    public function inventoryItems()
    {
        return $this->hasMany(InventoryItem::class);
    }
}
