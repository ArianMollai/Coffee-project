<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Table;

class Reservation extends Model
{
    protected $guarded=['id'];
    protected $table='reservation';

    public function User(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Table(){
        return $this->belongsTo(Table::class, 'table_id');
    }
}
