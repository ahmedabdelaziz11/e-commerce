<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Product extends Model
{
    use HasFactory,Translatable;

    public $translatedAttributes = ['name','description'];
    protected $fillable = [
        'price',
        'store_id ',
        'name',
        'description'
    ];


    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];
}
