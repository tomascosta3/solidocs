<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    protected $table = 'organizations';

    protected $fillable = [
        'business_name',
        'cuit',
        'province',
        'city',
        'country',
        'domain',
        'verified',
        'verified_by',
        'verified_at',
        'active'
    ];


    /**
     * Returns the users that belong to the organization.
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('access_level');
    }
}
