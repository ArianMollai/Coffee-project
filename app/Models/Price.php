<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\AttributteValue;
use App\Models\Price;
use App\Models\Ingridient;
use App\Models\PriceIngridient;
use App\Models\Table;

class Price extends Model
{
    protected $guarded=['id'];
    protected $table="prices";

    public function Product(){
        return $this->belongsTo(Product::class);
    }

    public function AttributeValues(){
        return $this->belongsToMany(AttributteValue::class, 'prices_attributevalues', 'price_id', 'attribute_value_id');
    }

    public function Table(){
        return $this->belongsTo(Table::class);
    }

    public function Ingridinets(){
        return $this->belongsToMany(Ingridient::class, 'price_ingridient')->using(PriceIngridient::class)->withPivot(['unit_id', 'volume']);
    }
}
