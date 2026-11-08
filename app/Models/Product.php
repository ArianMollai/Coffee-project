<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Table;
use App\Models\Price;
use App\Models\Category;
use App\Models\Ingridient;
use App\Models\Extra;
use App\Trait\HasImages;

class Product extends Model
{
    use HasImages;

    protected $guarded=['id'];
    protected $table='products';

/*     public function Table(){
        return $this->hasOne(Table::class, 'product_id');
    } */

    public function Prices(){
        return $this->hasMany(Price::class);
    }

    public function Categories(){
        return $this->belongsToMany(Category::class, 'products_categories');
    }

    public function Ingridients(){
        return $this->belongsToMany(Ingridient::class, 'ingridients_products');
    }

    public function Extras(){
        return $this->belongsToMany(Extra::class, 'products_extras');
    }
}
