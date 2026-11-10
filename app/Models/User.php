<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Role;
use App\Models\Cart;
use App\Models\Reservation;


#[Guarded(['id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements JWTSubject
{
    #[override]
    public function getJWTIdentifier(){
        return $this->getKey();
    }

     #[override]
    public function getJWTCustomClaims(){
        return [];
    } 
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function Roles(){
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    public function HasPermission(string $permissionName): bool
    {
        return $this->Roles()->whereHas('permissions', fn($q) => $q->where('name', $permissionName))->exists();
    }

    public function Cart(){
        return $this->hasOne(Cart::class, 'user_id');
    }

    public function Reservations(){
        return $this->hasMany(Reservation::class, 'user_id');
    }
}
