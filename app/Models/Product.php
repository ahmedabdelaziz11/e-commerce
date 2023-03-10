<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Product extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    protected $translationForeignKey = 'product_id';

    public $translatedAttributes = ['name','description'];
    protected $fillable = [
        'price',
        'store_id',
        'name',
        'description'
    ];


    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function storeOwner(){
        return $this->hasOneThrough(User::class, Store::class,'id','id','store_id','user_id');
    }

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];
}
