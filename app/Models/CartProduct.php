<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'unit_price',
        'product_id',
        'cart_id',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
