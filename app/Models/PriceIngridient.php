<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Unit;

class PriceIngridient extends Pivot
{
    protected $guarded=['id'];
    protected $table='price_ingridient';

    public function Unit(){
        return $this->belongsTo(Unit::class, 'unit_id');
    }
}
