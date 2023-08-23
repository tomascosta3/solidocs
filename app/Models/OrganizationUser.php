<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationUser extends Model
{
    use HasFactory;

    protected $table = 'organization_user';

    protected $fillable = [
        'user_id',
        'organization_id',
        'access_level'
    ];


    /**
     * User model relation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Organization model relation.
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
