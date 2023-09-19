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


    /**
     * Returns the access level of organization.
     */
    public function access_level_in_organization($organization_id) {

        return $this->organizations()->where('organization_id', $organization_id)->first()->pivot->access_level ?? null;
    }


    /**
     * Check if user belongs to organization.
     */
    public function belongs_to($organization_name) {

        return $this->organizations()->where('organizations.active', true)
            ->where('business_name', $organization_name)
            ->count() == 1;
    }

    
    public function days() {

        return $this->belongsToMany(Day::class, 'day_user')->withPivot('days_available');
    }


    public function day_requests() {

        return $this->hasMany(DayRequest::class);
    }

    public function days_of_type($type) {
        
        return $this->days()->where('type', $type)
            ->where('days.active', true)
            ->first();
    }


    /**
     * Returns user's related calendars.
     */
    public function calendars() {

        return $this->belongsToMany(Calendar::class);
    }


    /**
     * Gets the groups which the user belongs.
     */
    public function groups() {

        return $this->belongsToMany(Group::class)->where('active', true);
    }
}
