<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AttributteValue;

class Attribute extends Model
{
    protected $guarded=['id'];
    protected $table='attributes';

    public function AttributeValues(){
        return $this->hasMany(AttributteValue::class, 'attribute_id');
    }
}
