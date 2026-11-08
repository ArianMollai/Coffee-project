<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Price;

class Table extends Model
{
    protected $guarded=['id'];
    protected $table='tables';

    protected static function boot(){
        parent::boot();

        static::creating(function ($table){
            $table->uuid=(string) Str::uuid();

            $url=url('/menu/{$table->uuid}');

            $svg=QrCode::format('svg')->size(300)->generate($url);

            $table->qr_code= 'data:image/svg+xml;base64'. base64_encode($svg);
            
        });
    }

/*     public function Product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
 */

    public function Prices(){
        return $this->hasOne(Price::class);
    }
}
