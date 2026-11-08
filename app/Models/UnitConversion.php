<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Unit;

class UnitConversion extends Model
{
    protected $guarded=['id'];
    protected $table= 'unit_conversion';

    public function ToUnit(){
        return $this->belongsTo(Unit::class, 'to_unit_id');
    }

    public function FromUnit(){
        return $this->belongsTo(Unit::class, 'from_unit_id');
    }
}
