<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Unit;
use App\Models\Product;
use App\Models\IngridientPurchases;
use App\Models\Price;
use App\Models\PriceIngridient;

class Ingridient extends Model
{
    protected $guarded=['id'];
    protected $table= 'ingridients';

    public function Unit(){
        return $this->belongsTo(Unit::class, 'base_unit_id');
    }

    public function Products(){
        return $this->belongsToMany(Product::class, 'ingridients_products');
    }

    public function IngridientPurchases(){
        return $this->hasMany(IngridientPurchases::class, 'ingridient_id');
    }

    public function Prices(){
        return $this->belongsToMany(Price::class, 'price_ingridient')->using(PriceIngridient::class)->withPivot(['unit_id', 'volume']);
    }
}