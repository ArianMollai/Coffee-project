<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Permission;

class Role extends Model
{
    protected $guarded=['id'];
    protected $table='roles';

    public function Users()
    {
        return $this->belongsToMany(User::class, 'users_roles');
    }

    public function Permissions(){
        return $this->belongsToMany(Permission::class, 'roles_permissions');
    }

}
