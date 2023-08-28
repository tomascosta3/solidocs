<?php

namespace App\Models;

use App\Models\Organization;
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
            ->withTimestamps()
            ->where('organizations.active', true);
    }

    /**
     * Returns the user's login.
     */
    public function login()
    {
        return $this->hasOne(Login::class);
    }

    /**
     * Determine how many organizations the user belongs to.
     */
    public function organization_count() {

        return $this->organizations()->where('organizations.active', true)->count();
    }

    /**
     * Returns the first organization the user belongs to.
     */
    public function organization() {

        return $this->belongsToMany(Organization::class)
        ->withPivot('access_level')
        ->withTimestamps()
        ->where('organizations.active', true)
        ->first();
    }

    public function access_level_in_organization($organization_id) {

        return $this->organizations()->where('organization_id', $organization_id)->first()->pivot->access_level ?? null;
    }
}
