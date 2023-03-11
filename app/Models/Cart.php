<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_total',
        'shipping_cost',
        'vat_value',
        'user_id',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class,CartProduct::class,'cart_id','product_id')->withPivot('quantity','unit_price');
    }

    public function cartProducts()
    {
        return $this->hasMany(CartProduct::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
