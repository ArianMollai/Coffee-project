<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ingridient;
use App\Models\Unit;

class IngridientPurchases extends Model
{
    protected $guarded=['id'];
    protected $table="ingridient_purchases";

    public function Ingridient(){
        return $this->belongsTo(Ingridient::class, 'ingridient_id');
    }

    public function Unit(){
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}