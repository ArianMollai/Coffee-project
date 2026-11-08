<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Category extends Model
{
    protected $guarded= ['id'];
    protected $table='categories';

    public function Parent(){
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function Children()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('Children');
    }

    public function Products(){
        return $this->belongsToMany(Product::class, 'products_categories');
    }
}
