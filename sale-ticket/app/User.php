<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isRole($role)
    {
        if($this->role === $role) {
            return true;
        }
        return false;
    }

    /**
     * Get all of the orders for the user.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
