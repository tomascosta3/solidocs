<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'first_name',
        'last_name',
        'dni',
        'phone_number',
        'email',
        'password',
        'verified',
        'verified_at',
        'active'
    ];

    protected $hidden = [
        'password'
    ];


    /**
     * Returns the organizations the user belongs to.
     */
    public function organizations()
    {
        return $this->belongsToMany(Organization::class)
            ->withPivot('access_level')
            ->withTimestamps();
    }


    /**
     * Returns the user's login.
     */
    public function login()
    {
        return $this->hasOne(Login::class);
    }
}
