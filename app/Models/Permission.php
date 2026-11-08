<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Role;

class Permission extends Model
{
    protected $guarded=['id'];
    protected $table='permissions';

    public function Roles(){
        return $this->belongsToMany(Role::class, 'roles_permissions');
    }
}
