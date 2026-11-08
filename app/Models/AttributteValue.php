<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Attribute;
use App\Models\Price;

class AttributteValue extends Model
{
    protected $guarded=['id'];
    protected $table='attribute_value';

    public function Attribute(){
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }

    public function Prices(){
        return $this->belongsToMany(Price::class, 'prices_attributevalues');
    }


}
