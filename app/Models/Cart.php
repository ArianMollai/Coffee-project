<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use All\Models\User;

class Cart extends Model
{
    protected $guarded=['id'];
    protected $table="carts";

    public function User(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
