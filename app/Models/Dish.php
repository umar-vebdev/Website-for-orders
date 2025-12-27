<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    protected $fillable = ['name', 'price', 'weight'];

    public function items() {
        return $this->hasMany(OrderItem::class);
    }
}
