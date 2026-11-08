<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ingridient;
use App\Models\IngridientPurchases;
use App\Models\Price;
use App\Models\PriceIngridient;

class Unit extends Model
{
    protected $guarded=['id'];
    protected $table="units";

    public function Ingridient(){
        return $this->hasMany(Ingridient::class, 'base_unit_id');
    }

    public function IngridientPurchases(){
        return $this->hasMany(IngridientPurchases::class, 'unit_id');
    }

/*     public function Prices(){
        return $this->belongsToMany(Price::class, 'price_ingridient')->withPivot(['ingridient_id', 'volume']);
    } */

    public function PriceIngridient(){
        return $this->hasMany(PriceIngridient::class, 'unit_id');
    }
}
