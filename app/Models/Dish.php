<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    protected $fillable = ['name', 'price', 'category'];

    public static $categories = [
        'Самса', 
        'Выпечка с мясом', 
        'Сытная выпечка', 
        'Сладкая выпечка', 
        'Большие пироги', 
        'Хлеб'
    ];
    
    public function items() {
        return $this->hasMany(OrderItem::class);
    }
}
