<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;


class Extra extends Model
{
    protected $guarded=['id'];
    protected $table="extras";

    public function Products(){
        return $this->belongsToMany(Product::class, 'products_extras');
    }
}
